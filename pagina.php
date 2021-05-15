<?php
	$pid = $_GET["pid"];
	$sql = "select texto from pagina where id =$pid";
	$res =$con->query($sql);
	$row = $res->fetch_assoc();
	
	echo utf8_encode($row['texto']);

?>