<?php
	header('Content-type: application/json');
	include("../conecta.php");

	// $sql = "SELECT id, DATE_FORMAT(data,'%d/%m/%Y') as data_noticia,
	// 			texto
	// 			FROM noticia 	WHERE year(data) = '2017'";
$sql = "SELECT id, DATE_FORMAT(data,'%d/%m/%Y') as data_noticia,
				texto
				FROM noticia where id>1820 ORDER BY id DESC";
	$res=$con->query($sql);
	$total = $res->num_rows;

	if ($res->num_rows>0){
		while ($row = $res->fetch_assoc()){
			// $valores = array("\t","\r","&gt");
			// $sub = array('','','');
			// $row['texto'] = str_replace($valores,$sub,$row['texto']);
			$json[] = $row;
		}
	}

	echo json_encode($json);
	//print_r($json);
 ?>
