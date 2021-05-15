<?php
session_start();
include 'conecta.php';

//atualiza o campo ultimo login
$sql = "select now() as agora";
$res = $con->query($sql);
$data = $res->fetch_assoc();
$data=$data['agora'];
$callsign = $_SESSION['callsign'];
$sql = "update piloto set ultimo_login = '$data' where callsign=$callsign";
$con->query($sql);

$_SESSION['callsign'] = NULL;
unset($_SESSION['callsign']);
session_destroy();

?><script language="Javascript">
	window.open("index.php?pagina=inicio","_parent");
</script>

