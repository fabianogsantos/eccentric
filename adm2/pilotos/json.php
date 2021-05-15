<?php
	header('Content-type: application/json');
	include("../../conecta.php");

	$filtro = empty($_GET['filtro'])?'a':$_GET['filtro'];

	$sql = "select callsign,convert(nome_guerra using utf8) as nome, 
			elt(field(piloto.status,'i','a'),'<span class=\"label label-danger\">Inativo</span>','<span class=\"label label-success\">Ativo</span>') as status, '' as teste
			from piloto where status='$filtro' order by callsign";
	$res=$con->query($sql);

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