<?php
include('../include/mandaemail.php');
$num_candidato = $_POST['num_candidato'];
$nome_guerra = $_POST['nome_guerra'];
$nucleo = $_POST['nucleo'];
$acao = (int) $_POST['acao'];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = 'From: Presidente <presidente@eccentrictravels.org>';

$assunto = "Sua inscrição na Eccentric Travels";

$sql_original = "select * from candidato where num_candidato=$num_candidato";
$res = $con->query($sql_original);
$row = $res->fetch_assoc();

$hoje = br2ansi(date("d/m/Y",time()));

$nome = empty($nome)?'':$_POST['nome'];

$nome 			= $row['nome'];
$cidade			= $row['cidade'];
$uf				= $row['uf'];
$pais			= $row['pais'];
$email			= $row['email'];
$email2			= $row['email2'];
$dataNasc		= $row['data_nasc'];
$telRes 		= $row['tel_res'];
$profissao		= $row['profissao'];
$versao			= $row['versao_fs'];
$voos			= $row['voos_online'];
$pid			= $row['pid'];
$vid			= $row['vid'];
$internet		= $row['internet'];
$cpf			= $row['cpf'];
$rg				= $row['rg'];
$motivo			= $row['motivo'];

switch($acao) {
	case 2:
		$sql = "update candidato set status=$acao,nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
		$res = $con->query($sql);
		echo "O candidato foi para a fila de espera.<br>";

		$sql = "select texto from cartas_email where id = 9";
		
		break;
	case 3:
		$hoje = br2ansi(Date("d/m/y"));
		$sql = "update candidato set status=$acao, data_convocacao='$hoje',nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
		$res = $con->query($sql);
		echo "O Candidato foi convocado.<br>";
		$sql = "select texto from cartas_email where id = 1";
		
		break; 

	case 4: 
		$hoje = br2ansi(Date("d/m/y"));
		$sql = "update candidato set status=$acao, data_convocacao='$hoje',nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
		$res = $con->query($sql);
		echo "O Candidato foi convocado.<br>";
		$sql = "select texto from cartas_email where id = 3";
		$res = $con->query($sql);
		
		break;

	case 5: 
		$hoje = br2ansi(Date("d/m/y"));
		$sql = "update candidato set status=$acao, data_convocacao='$hoje',nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
		$res = $con->query($sql);
		echo "O Candidato foi convocado.<br>";
		$sql = "select texto from cartas_email where id = 5";

		break;
	
	case 6: 
		$sql = "update candidato set status=$acao,nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
		$res = $con->query($sql);
		echo "O candidato foi classificado como menor de idade.<br>";

		$sql = "select texto from cartas_email where id = 7";
		break; 

	case 7: 
		$sql = "update candidato set status=$acao,nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
		$res = $con->query($sql);
		echo "O candidato não preencheu a ficha de inscrição completamente.";

		$sql = "select texto from cartas_email where id = 8";
		break;

	case 8: 
		$sql = "update candidato set status=$acao,nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
		$res = $con->query($sql);
		echo "<script>
        		bootbox.alert(\"Inscrição cancelada.\");
						window.location=\"index.php?pagina=fila_espera/candidatos\";
          </script>";
		break;

	case 10:
		$senha = geraSenha();
		echo "Senha gerada.<br>";

		$hoje = date('Y-m-d');
		//verifica o ultimo piloto para pegar o callsign

		$sql = "select max(callsign) as ultimo from piloto";
		$res = $con->query($sql);
		$row = $res->fetch_assoc();
		$ultimo = $row['ultimo']+1;

		$sqlIns = "insert into piloto (nome,nome_guerra,cidade,uf,pais,status,data_ingresso,email,email2,cod_posto,nucleo,data_nasc,tipo_piloto,tel_res,profissao,versao_fs,voos_online,pid,vid,cpf,rg,motivo,senha) values ('$nome','$nome_guerra','$cidade','$uf','$pais','a','$hoje','$email','$email2',1,'$nucleo','$dataNasc','n','$telRes','$profissao','$versao','$voos','$pid','$vid','$cpf','$rg','$motivo','$senha')";
		$res = $con->query($sqlIns);

		$sqlDossie = "insert into dossie_piloto (callsign, qtd_horas_voo, qtd_voos, qtd_estrelas, qtd_vf, qtd_vh, qtd_me, qtd_op,data_ult_voo,ultimos_voos,qtd_voos_ae_desat, flg_estavel,tempovoooffline,tempovooivao,tempovoovatsim,tempovoooutras,qtdvoosoffline,qtdvoosvatsim,qtdvoosivao,qtdvoosoutras,qtd_estrela_ouro,qtd_diploma_estrela_ouro) values ($ultimo,0,0,0,0,0,0,0,$hoje,'',0,0,'','','','',0,0,0,0,0,0)";
		$res = $con->query($sqlDossie);

		$sqlDel = "delete from candidato where num_candidato=$num_candidato";
		$res = $con->query($sqlDel);

		$sql = "select callsign from piloto where nome_guerra like '$nome_guerra'";
		$res = $con->query($sql);
		$row = $res->fetch_assoc();
		$novoCallsign = $row['callsign'];

		echo "O candidato foi efetivado como piloto com o callsign ETR-".$novoCallsign.".<br>";

		//prepara email
		$msg = "<html><body><p>Prezado Cmte. ".$nome_guerra."</p><br><br><p>Parabens! Você foi efetivado como piloto na Eccentric Travels.</p>Abaixo estão seus dados para uso interno e acesso ao nosso site:<br>Callsign: ".$novoCallsign."<br>Senha: ".$senha."<br></p><p>Qualquer dúvida, entre em contato conosco.</body></html>";
		break;
	}
	if ($opcao<>8){
		if ($opcao<>10){
			$res = $con->query($sql);
			$row = $res->fetch_assoc();
			$msg = $row['texto'];
		}
		
		$result = mail($email, $assunto, $msg, implode("\r\n", $headers));

		if ($result)    //($recipients, $to, $subject, $body)
			echo "Email enviado.<br>";
		else
			echo "Ocorreu um erro durante o envio do email.";
	}
