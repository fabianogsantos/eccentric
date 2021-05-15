<?php
$num_candidato = $_POST['num_candidato'];
$nome_guerra = $_POST['nome_guerra'];
$nucleo = $_POST['nucleo'];
$acao = (int) $_POST['acao'];

$sql_original = "select * from candidato where num_candidato=$num_candidato";
$res = $con->query($sql_original);
$row = $res->fetch_assoc();

$hoje = br2ansi(date("d/m/Y",time()));

$nome = empty($nome)?'':$_POST['nome'];

if ($nome=='')
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

if ($acao==10){
	$senha = geraSenha();
	echo "Senha gerada.<br>";

	$hoje = date('Y-m-d');
	//verifica o ultimo piloto para pegar o callsign
	$sql = "select max(callsign) as ultimo from piloto";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	$ultimo = $row['ultimo']+1;

	$sqlIns = "insert into piloto (callsign,nome,nome_guerra,cidade,uf,pais,status,data_ingresso,email,email2,cod_posto,nucleo,data_nasc,tipo_piloto,tel_res,profissao,versao_fs,voos_online,pid,vid,cpf,rg,motivo,senha) values ($ultimo,'$nome','$nome_guerra','$cidade','$uf','$pais','a','$hoje','$email','$email2',1,'$nucleo','$dataNasc','n','$telRes','$profissao','$versao','$voos','$pid','$vid','$cpf','$rg','$motivo','$senha')";
	$res = $con->query($sqlIns);

	$sqlDossie = "insert into dossie_piloto (callsign, qtd_horas_voo, qtd_voos, qtd_estrelas, qtd_vf, qtd_vh, qtd_me, qtd_op,data_ult_voo,ultimos_voos,qtd_voos_ae_desat, flg_estavel,tempovoooffline,tempovooivao,tempovoovatsim,tempovoooutras,qtdvoosoffline,qtdvoosvatsim,qtdvoosivao,qtdvoosoutras,qtd_estrela_ouro,qtd_diploma_estrela_ouro) values ($ultimo,0,0,0,0,0,0,0,$hoje,'',0,0,'','','','',0,0,0,0,0,0)";
	$res = $con->query($sqlDossie);

	$sqlDel = "delete from candidato where num_candidato=$num_candidato";
	$res = $con->query($sqlDel);

	$sql = "select callsign from piloto where nome_guerra like '$nome_guerra'";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	$novoCallsign = $row['callsign'];

	echo "O candidato foi efetivado como piloto.<br>";

	//prepara email
	$assunto = "Sua inscrição na Eccentric Travels";
	$msg = "<html><body><p>Prezado Cmte. ".$nome_guerra."</p><br><br><p>Parabens! Você foi efetivado como piloto na Eccentric Travels.</p>Abaixo estão seus dados para uso interno e acesso ao nosso site:<br>Callsign: ".$novoCallsign."<br>Senha: ".$senha."<br></p><p>Qualquer dúvida, entre em contato conosco.</body></html>";

	echo "<hr>";
	echo "<p>Favor enviar um e-mail para o candidato:</p>";
	echo "<p>E-mail do candidato: ".$email."</p>";
	echo "<p>Texto da mensagem:</p>";
	echo $msg;
}
else {

	if($acao==2){ //fila de espera, id tabela cartas_email = 9
		$sql = "update candidato set status=$acao,nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
		$res = $con->query($sql);
		echo "O candidato foi para a fila de espera.<br>";

		$sql = "select texto from cartas_email where id = 9";
		$res = $con->query($sql);
		$row = $res->fetch_assoc();

		$msg = utf8_encode($row['texto']);

		$headers = "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: Presidente <presidente@eccentrictravels.org>\r\n";


		if (mail($email, $assunto, $msg, $headers))
			echo "Email enviado para o candidato.<br>";
		else
			echo "Ocorreu um erro durante o envio do email.";

	}
	if (($acao>=3)and($acao<=5)) {
		$hoje = br2ansi(Date("d/m/y"));
		$sql = "update candidato set status=$acao, data_convocacao='$hoje',nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
		$res = $con->query($sql);
		echo "O Candidato foi convocado.<br>";
		//enviaEmail($num_candidato,$acao);

		if ($acao==3){  //convoc SP //id da tabela = 1(portugues), 2 (espanhol)
			$sql = "select texto from cartas_email where id = 1";
			$res = $con->query($sql);
			$row = $res->fetch_assoc();

			$msgPort = utf8_encode($row['texto']);

			echo "<hr>";
			echo "<p>Favor enviar um e-mail para o candidato:</p>";
			echo "<p>E-mail do candidato: ".$email."</p>";
			echo "<p>Texto da mensagem:</p>";
			echo $msgPort;
		}
		if ($acao==4){ //convoc RJ, id = 3 e 4
			$sql = "select texto from cartas_email where id = 3";
			$res = $con->query($sql);
			$row =$res->fetch_assoc();

			$msgPort = $row['texto'];

			echo "<hr>";
			echo "<p>Favor enviar um e-mail para o candidato:</p>";
			echo "<p>E-mail do candidato: ".$email."</p>";
			echo "<p>Texto da mensagem:</p>";
			echo $msgPort;
		}
		if ($acao==5){
			$sql = "select texto from cartas_email where id = 5";
			$res = $con->query($sql);
			$row = $res->fetch_assoc();

			$msgPort = utf8_encode($row['texto']);

			echo "<hr>";
			echo "<p>Favor enviar um e-mail para o candidato:</p>";
			echo "<p>E-mail do candidato: ".$email."</p>";
			echo "<p>Texto da mensagem:</p>";
			echo $msgPort;
		}

		if ($acao==6){	//menor, id=7
			$sql = "update candidato set status=$acao,nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
			$res = $con->query($sql);
			echo "O candidato foi classificado como menor de idade.<br>";

			$sql = "select texto from cartas_email where id = 7";
			$res = $con->query($sql);
			$row = $res->fetch_assoc();

			$msg = utf8_encode($row['texto']);

			echo "<hr>";
			echo "<p>Favor enviar um e-mail para o candidato:</p>";
			echo "<p>E-mail do candidato: ".$email."</p>";
			echo "<p>Texto da mensagem:</p>";
			echo $msg;
		}

		if ($acao==7){	//incompleta, id=8
			$sql = "update candidato set status=$acao,nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
			$res = $con->query($sql);
			echo "O candidato não preencheu a ficha de inscrição completamente.";

			$sql = "select texto from cartas_email where id = 8";
			$res = $con->query($sql);
			$row = $res->fetch_assoc();

			$msg = utf8_encode($row['texto']);
			echo "<hr>";
			echo "<p>Favor enviar um e-mail para o candidato:</p>";
			echo "<p>E-mail do candidato: ".$email."</p>";
			echo "<p>Texto da mensagem:</p>";
			echo $msg;
		}
		if ($acao==8){	//cancelado
			$sql = "update candidato set status=$acao,nome_guerra='$nome_guerra',nucleo='$nucleo' where num_candidato=$num_candidato";
			$res = $con->query($sql);
			echo "A inscrição do candidato foi cancelada.";
		}
}
if ($acao==11){
	$sql = "delete from candidato where num_candidato=$num_candidato";
	$res = $con->query($sql);
	echo "Todos os dados do candidato foram pro saco.";
}
?>
