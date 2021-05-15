<?php 
	header('Content-type: application/json');
	include("../../conecta.php");

    $query_rs = "SELECT icao from icao where icao like '"order by icao ";
    $rs = $con->query($query_rs);
    $row_rs = $rs->fetch_assoc();
    $totalRows_rs = $rs->num_rows;

	if ($rs->num_rows>0){
		while ($row = $rs->fetch_assoc()){
			$json[] = $row;
        }
	}
	echo json_encode($json);
