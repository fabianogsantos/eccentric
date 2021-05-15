<?php
  	include("../../configura.php");
	include("../../conecta.php");
  	include("../../funcoes.php");
$num_candidato = '111';
$nome_guerra = 'TESTE';
$nucleo = 'sp';
$acao = (int) $_GET['acao'];
$email = "fabianogs@gmail.com";

$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = 'From: Presidente <presidente@eccentrictravels.org>';


if ($acao==10){
	$senha = geraSenha();
	echo "Senha gerada.<br>";

	$hoje = date('Y-m-d');


	//prepara email
	$assunto = "Sua inscrição na Eccentric Travels";
	$msg = "<html><Prezado Cmte. ".$nome_guerra."</p><br><br><p>Parabens! Você foi efetivado como piloto na Eccentric Travels.</p>Abaixo estão seus dados para uso interno e acesso ao nosso site:<br>Callsign: ".$novoCallsign."<br>Senha: ".$senha."<br></p><p>Qualquer dúvida, entre em contato conosco.</body></html>";

	//vou repetir esse codigo, depois crio uma função para ele
    $result = mail($email, $assunto, $msg, implode("\r\n", $headers));
	
	if ($result)    //($recipients, $to, $subject, $body)
		echo "Email enviado para o novo piloto.<br>";
	else
		echo "Ocorreu um erro durante o envio do email.";
}

else {
	$assunto = "Sua inscrição na Eccentric Travels";
		echo "O candidato foi para a fila de espera.<br>";

		$sql = "select texto from cartas_email where id = 9";
		$res = $con->query($sql);
		$row = $res->fetch_assoc();

		$msg = $row['texto'];

        $result = mail($email, $assunto, $msg, implode("\r\n", $headers));
		
		if ($result)    
			echo "Email enviado.<br>";
		else
			echo "Ocorreu um erro durante o envio do email.";
	}

?>
