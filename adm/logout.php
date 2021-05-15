<?php
session_start();

//atualiza o campo ultimo login 
$sql = "select now()";
$res = mysql_query($sql);
$data = mysql_result($res,0);
$sql = "update piloto set ultimo_login = '$data'";
mysql_query($sql);

$_SESSION['callsign'] = NULL;  
unset($_SESSION['callsign']);
session_destroy();
?><script language="Javascript">
	window.open("index.php?pagina=inicio","_parent");
</script>