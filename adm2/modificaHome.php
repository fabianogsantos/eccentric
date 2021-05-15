<?php
	session_start();
	if(!isset($_SESSION["callsign"])){
		?><script language="Javascript">
				window.open("index.php","_parent");
		</script><?
    	exit;
	}
	
include("../conecta.php");
include("../funcoes.php");


$sql = "update pagina set texto = '".$_POST['mensagem']."' where id = 1";
  $Result1 = mysql_query($sql) or die(mysql_error());
  
  ?>
  
	<script language="Javascript">
	<!--
		alert("Página atualizada!");
		window.open("index.php?pagina=inicio","_self");
	//-->
	</script>  
