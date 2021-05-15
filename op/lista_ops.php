<?php 
	header('Content-type: application/json');
	include("../conecta.php");
	$callsign = $_GET['callsign'];

	$sql = "SELECT num_op,
				escalas,
				aeronave.nome as aeronave,
				elt(field(op.status,'p','a','r','c','f'),'Aguarde aprovação','Aprovada','Reprovada','Cancelada','Finalizada') as status,
				date_format(data_pedido,'%d/%m/%Y') as data_pedido
			FROM op,aeronave 
			WHERE callsign=$callsign 
			and op.cod_aeronave = aeronave.cod_aeronave
			order by num_op desc";
	$res=$con->query($sql);
	$total = $res->num_rows;

	if ($res->num_rows>0){
		while ($row = $res->fetch_assoc()){
			$json[] = $row;
		}
	}
	//echo json_encode(array('total'=>$total,'rows'=>$json));
	echo json_encode($json);
