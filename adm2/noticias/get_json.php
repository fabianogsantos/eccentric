<?php 
	header('Content-type: application/json');
	include("../../conecta.php");

	$sql = "SELECT id, DATE_FORMAT(data, '%d/%m/%Y') as data, texto
			FROM noticia
			order by id desc";
	$res=$con->query($sql);
	$total = $res->num_rows;

	$json=array();
	if ($res->num_rows>0){
		while ($row = $res->fetch_assoc()){
			$row = array_map('utf8_encode',$row);
			array_push($json,$row);
        }
	}
	// $arr = array_map('utf8_encode',$json);
	 echo json_encode($json);
 ?>