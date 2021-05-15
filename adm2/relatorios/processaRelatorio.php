<?php
include('mandaemail.php');
$numero = $_POST['numero'];
$modo = $_POST['modo'];
$tipo = $_POST['tipo'];
$numeroVoo = $_POST['numero_voo'];
$icao_origem = $_POST['icao_origem'];
$icao_destino = $_POST['icao_destino'];
$data_partida =  br2ansi($_POST['data_partida']);
$tempo_voo = $_POST['tempo_voo'];
$cod_aeronave = $_POST['cod_aeronave'];
$distancia = $_POST['distancia'];
$altitude = $_POST['altitude'];
$combustivel = $_POST['combustivel'];
$plano_voo = $_POST['plano_voo'];

$sql = "update relatorios set modo = '$modo', tipo='$tipo', numero_voo='$numeroVoo', icao_origem='$icao_origem', icao_destino='$icao_destino', data_partida='$data_partida', tempo_voo='$tempo_voo',cod_aeronave=$cod_aeronave, distancia=$distancia,altitude=$altitude,combustivel=$combustivel,plano_voo='$plano_voo' where numero=$numero";
$res = $con->query($sql);

$acao = (int) $_POST['acao'];

$sql = "select p.callsign, p.data_ingresso, nome_guerra,email from piloto p, relatorios r where r.callsign = p.callsign and r.numero = $numero";
$res = $con->query($sql);
$row = $res->fetch_assoc();
$nome_guerra  = $row['nome_guerra'];
$dataIngresso = ansi2br($row['data_ingresso']);
$numPiloto    = $row['callsign'];
$email        = $row['email'];

$sql = "update relatorios set status = $acao where numero=$numero";
$res = $con->query($sql);

$sql = "select * from relatorios where numero=$numero";
$res = $con->query($sql);
$row_rsrelatorio = $res->fetch_assoc();

$sqlPil = "select * from dossie_piloto where callsign = $numPiloto";
$resPil = $con->query($sqlPil);
$rowPil = $resPil->fetch_assoc();


echo "<h4>Log do relat&oacute;rio</h4>";

switch ($acao) {
	case 2:
		//APROVAR RELATORIO
		//somar numero de horas
		$numHoras = soma_horas($rowPil['qtd_horas_voo'], $row_rsrelatorio['tempo_voo']);
		echo "N&uacute;mero de horas de voo somado. Total de horas = " . $numHoras . "<br>";

		//processa numero de estrelas
		$qtdEstrelasOri = $rowPil['qtd_Estrelas'];
		$novaQtdEstrelas = $numHoras / 100;

		//incrementa qtd_voos
		$qtdVoos = $rowPil['qtd_Voos'] + 1;
		echo "Quantidade de voos incrementado. N&uacute;mero de voos = " . $qtdVoos . "<br>";

		//incrementa voos na aeronave do relatorio
		$anvRel = $row_rsrelatorio['cod_aeronave'];
		$sqlAnv = "select distinct pa.qtd_voos from piloto_aeronave pa, piloto p where pa.callsign=$numPiloto and pa.cod_aeronave = $anvRel";
		$res = $con->query($sqlAnv);
		$row = $res->fetch_assoc();

		if ($res->num_rows == 0) {
			$sql = "insert into piloto_aeronave (callsign, cod_aeronave, qtd_voos) values ($numPiloto,$anvRel,1)";
		} else {
			$qtdVoosAnv = $row['qtd_voos'];
			$qtdVoosAnv = $qtdVoosAnv + 1;
			$sql = "update piloto_aeronave set qtd_voos = $qtdVoosAnv where callsign = $numPiloto and cod_aeronave = $anvRel";
		}
		$res = $con->query($sql);
		echo "N&uacute;mero de voos na aeronave atualizado. Aeronave = " . $anvRel . " - Qtde = " . $qtdVoosAnv . "<br>";

		//verifica se virou instrutor
		$hoje = br2ansi(Date("d/m/Y"));
		if ($qtdVoosAnv == 50) {
			$sql = "update piloto_qo set data_qo = '$hoje' where callsign = $numPiloto and cod_aeronave=$anvRel and tipo_qo='i'";
			$res = $con->query($sql);
			echo "Piloto qualificou-se como instrutor da aeronave.<br>";
		}

		if ($qtdVoosAnv == 100) {
			$sql = "update piloto_qo set data_qo = '$hoje' where callsign = $numPiloto and cod_aeronave=$anvRel and tipo_qo='c'";
			$res = $con->query($sql);
			echo "Piloto qualificou-se como comandante-mor da aeronave.<br>";
		}

		//atualiza ultimo voo
		$dataVooRelat = $row_rsrelatorio['data_partida'];
		echo "Data do &Uacute;ltimo voo atualizada = " . ansi2br($data_partida) . "<br />";
		echo "&Uacute;ltimo voo realizado = " . $numeroVoo . "<br />";

		//atualiza numero de op, se for op, claro!! :-)
		if (right($numeroVoo, 2) == "FE") {
			$sqlOp = "select qtd_op from dossie_piloto where callsign = $numPiloto";
			$resOp = $con->query($sqlOp);
			$rowOp = $resOp->fetch_assoc();

			$qtdOp = $rowOp['qtd_op'];
			$qtdOp = $qtdOp + 1;
			$sqlOp = "update dossie_piloto set qtd_op=$qtdOp where callsign = $numPiloto";
			$resOp = $con->query($sqlOp);
		}

		//verifica se é piloto fiel
		$hoje = Date("d/m/Y");
		$tempoCia = date_diff2($dataIngresso, $hoje);

		if ($tempoCia >= 365) {
			//é piloto fiel
			//verifica se o cara já é piloto fiel
			$sql = "select * from piloto_certificado where callsign = $numPiloto and cod_certificado=1";
			$res = $con->query($sql);
			$num = $res->num_rows;

			if ($num == 0) {
				//o cara não é, então insere ele como piloto fiel
				$hoje = br2ansi($hoje);
				$sql = "insert into piloto_certificado (callsign, cod_certificado, data_certificado) values ($numPiloto, 1, '$hoje');";
				$res = $con->query($sql);
				echo "Piloto ganhou o certificado de Piloto Fiel.<br>";
			}
		}

		$hoje = br2ansi(Date("d/m/Y"));
		$sqlUpd = "update dossie_piloto set ultima_alt_dossie= '$hoje',qtd_horas_voo = '$numHoras', qtd_Voos = $qtdVoos, data_ult_voo='$dataVooRelat',ultimos_voos='$numeroVoo' where callsign = $numPiloto";
		$res = $con->query($sqlUpd);

		//atualiza campos de voos offline/online

		//obtem os dados atuais do dossie
		$sql = "select * from dossie_piloto where callsign=$numPiloto";
		$res = $con->query($sql);
		$row = $res->fetch_assoc();

		$qtdvoosoffline = $row['qtdvoosoffline'];
		$qtdvoosivao = $row['qtdvoosivao'];
		$qtdvoosvatsim = $row['qtdvoosvatsim'];
		$qtdvoosoutras = $row['qtdvoosoutras'];
		$tempovoooffline = $row['tempovoooffline'];
		$tempovooivao = $row['tempovooivao'];
		$tempovoovatsim = $row['tempovoovatsim'];
		$tempovoooutras = $row['tempovoooutras'];
		$qtdEstrelaOuro = $row['qtd_estrela_ouro'];
		$qtdDiplomaEstrelaOuro = $row['qtd_diploma_estrela_ouro'];


		//modo OFFLINE
		if ($modo == 'o') {
			$qtd = $qtdvoosoffline + 1;
			$tempo = soma_horas($tempovoooffline, $tempo_voo);
			$sql = "update dossie_piloto set qtdvoosoffline = $qtd, tempovoooffline='$tempo' where callsign = $numPiloto";
			$res = $con->query($sql);
			echo "Voo Offfine. Quantidade de voos offline: " . $qtd . "<br/>Tempo de voo offline: " . $tempo . "<br/>";
		};

		//VATSIM
		if ($modo == 'v') {
			$qtd = $qtdvoosvatsim + 1;
			$tempovoovatsim = soma_horas($tempovoovatsim, $tempo_voo);
			$sql = "update dossie_piloto set qtdvoosvatsim = $qtd, tempovoovatsim='$tempovoovatsim' where callsign = $numPiloto";
			$res = $con->query($sql);
			echo "Voo pela Vatsim. Quantidade de voos na Vatsim: " . $qtd . "<br/>Tempo de voo na Vatsim: " . $tempovoovatsim . "<br/>";
		};

		//IVAO
		if ($modo == 'i') {
			$qtd = $qtdvoosivao + 1;
			$tempovooivao = soma_horas($tempovooivao, $tempo_voo);
			$sql = "update dossie_piloto set qtdvoosivao = $qtd, tempovooivao='$tempovooivao' where callsign = $numPiloto";
			$res = $con->query($sql);
			echo "Voo pela Ivao. Quantidade de voos na Ivao: " . $qtd . "<br/>Tempo de voo na Ivao: " . $tempovooivao . "<br/>";
		};

		//trata estrelas de ouro
		$somaTemposOnline = soma_horas($tempovooivao, $tempovoovatsim);
		$somaTemposOnline = soma_horas($somaTemposOnline, $tempovoooutras);
		echo 'somatemposonline=' . $somaTemposOnline;
		echo '<br>';
		$qtdEstrelasOuro = truncate($somaTemposOnline / 100);

		$sql = "update dossie_piloto set qtd_estrela_ouro = $qtdEstrelasOuro where callsign = $numPiloto";
		$res = $con->query($sql);

		if ($qtdEstrelasOuro <> $qtdEstrelaOuro)
			echo "N&uacute;mero de estrelas de ouro alterado para: " . $qtdEstrelasOuro . "<br/>";

		//trata diplomas
		$qtdDiplomas = truncate($qtdEstrelasOuro / 10);
		$sql = "update dossie_piloto set qtd_diploma_estrela_ouro = $qtdDiplomas where callsign = $numPiloto";
		$res = $con->query($sql);

		if ($qtdDiplomas <> $qtdDiplomaEstrelaOuro)
			echo "N&uacute;mero de diplomas de estrelas de ouro alterado para: " . $qtdDiplomasEstrelasOuro . "<br/>";

		echo "<br/><br/>O relat&oacute;rio foi aprovado";
		$assunto = "Relatorio de voo aprovado";
		$msg2 = "<p>O seu relat&oacute;rio de voo foi aprovado.</p>";
		break;

	case 3:
		echo "O relat&oacute;rio foi reprovado";
		$assunto = "Relat&oacute;rio de voo reprovado";
		$msg2 = "<p>O seu relat&oacute;rio de voo foi reprovado.</p>";
		break;

	case 4:
		echo "O relat&oacute;rio foi cancelado";
		$assunto = "Relat&oacute;rio de voo cancelado";
		$msg2 = "<p>O seu relat&oacute;rio de voo foi cancelado.</p>";
		break;

	case 5:
		echo "O relat&oacute;rio est&aacute; pendente";
		exit;
		break;
}

$codAero = $row_rsrelatorio['cod_aeronave'];
$sql = "select nome from aeronave where cod_aeronave = $codAero";
$res = $con->query($sql);
$row = $res->fetch_assoc();
$nomeAero = $row['nome'];
$aeronave = $codAero . " - " . $nomeAero;

$msg = "<html><body><p>Prezado Cmte. " . $nome_guerra . ", " . $msg2 .
	"<p><strong>N&uacute;mero do relat&oacute;rio: </strong>" . $row_rsrelatorio['numero']
	. "<p><strong>Callsign: </strong>" . $row_rsrelatorio['callsign']
	. "<p><strong>Modo :</strong>" . $row_rsrelatorio['modo']
	. "<p><strong>Tipo do voo: </strong>" . trataTipoVoo($row_rsrelatorio['tipo'])
	. "<p><strong>N&uacute;mero do voo: </strong>" . ansi2br($row_rsrelatorio['numero_voo'])
	. "<p><strong>ICAO Origem: </strong>" . $row_rsrelatorio['icao_origem']
	. "<p><strong>ICAO Destino: </strong>" . $row_rsrelatorio['icao_destino']
	. "<p><strong>Data Partida: </strong>" . ansi2br($row_rsrelatorio['data_partida'])
	. "<p><strong>Tempo de Voo: </strong>" . $row_rsrelatorio['tempo_voo']
	. "<p><strong>Aeronave: </strong>" . $aeronave
	. "<p><strong>Dist&acirc;ncia: </strong>" . $row_rsrelatorio['distancia']
	. "<p><strong>N&iacute;vel de voo: </strong>" . $row_rsrelatorio['altitude']
	. "<p><strong>Combust&iacute;vel: </strong>" . $row_rsrelatorio['combustivel']
	. "<p><strong>Plano de voo: </strong>" . trataPlanoVoo($row_rsrelatorio['plano_voo'])
	. "</body></html>";

if (mandaEmail($email, 'Dados do relatório', $msg)) {
	echo "<br>Email enviado para piloto.<br>";
} else
	echo "Ocorreu um erro durante o envio do email.";
?>
<br />
<hr>
<p><a href="index.php?pagina=relatorios/relatorios">Voltar para Administra&ccedil;&atildeo de Relat&oacute;rios</a></p>