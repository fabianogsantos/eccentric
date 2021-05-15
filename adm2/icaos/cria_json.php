<?php 
	header('Content-type: application/json');
	include("../../conecta.php");

	$sql = "SELECT icao,
				cidade
			FROM icao
			ORDER BY icao";
	$res=$con->query($sql);
	$total = $res->num_rows;

	if ($res->num_rows>0){
		while ($row = $res->fetch_assoc()){
			$json[] = $row;
        }
        //$json = array_push($json,"a");
	}

	//echo json_encode(array('total'=>$total,'rows'=>$json));
	echo json_encode($json);
 ?>