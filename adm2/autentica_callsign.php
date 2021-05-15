<?php
include("../conecta.php");
//RECEBE OS DADOS DO FORMUL�RIO
$callsign = $_POST['callsign'];
$senha = $_POST['senha'];

//VERIFICA
$sql = "SELECT callsign,nome_guerra,status,senha FROM piloto WHERE callsign = '$callsign' AND senha = '$senha' and status='a'";
$res = $con->query($sql);
$row = $res->num_rows;

//VERIFICA SE RETORNOU ALGO
if($row == 0){
	?><script language="Javascript">
	<!--
	window.open("index.php?pagina=falha_login","_self");
	//-->
	</script><?php
	exit;
}


else {
//PEGA OS DADOS
	$lin = $res->fetch_assoc();
	$callsign = $lin["callsign"];
	$nome_guerra = $lin["nome_guerra"];
	$status = $lin["status"];
	$senha = $lin["senha"];

	if(!$nome_guerra || !$senha)	{
	    echo "Voce deve digitar sua senha e login!";
    	exit;
}


//INICIALIZA A SESS�O
session_start();
?>
<div align="center" class="style1">Conectando ... Aguarde !!!</div><?php

//GRAVA AS VARI�VEIS NA SESS�O
$_SESSION["callsign"] = $callsign;
$_SESSION["senha"]= $senha;
?>
<script language="Javascript">
window.open("index.php?pagina=inicio","_parent");

</script><?php
} //FECHA ELSE
?>
