<?php 
	header('Content-type: application/json');
	include("../../conecta.php");

	$sql = "SELECT cod_aeronave,nome,versao from aeronave";
	$res=$con->query($sql);
	$total = $res->num_rows;

	$json=array();
	if ($res->num_rows>0){
		while ($row = $res->fetch_assoc()){
			$row = array_map('utf8_encode',$row);
			array_push($json,$row);
        }
	}
	 echo json_encode($json);
 ?>