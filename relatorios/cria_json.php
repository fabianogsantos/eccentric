<?php 
	header('Content-type: application/json');
	include("../conecta.php");
	$callsign = $_GET['callsign'];

	$sql = "SELECT numero,
				DATE_FORMAT(data_envio_relatorio,'%d/%m/%Y') as data_envio_relatorio,
				nome as aeronave,
				numero_voo,
				upper(icao_origem) as icao_origem,
				upper(icao_destino) as icao_destino,
				DATE_FORMAT(data_partida,'%d/%m/%Y') as data_partida,
				tempo_voo,
				elt(field(relatorios.status,1,2,3,4,5),'Aguardando','Aprovado','Reprovado','Cancelado','Pendente')as status
			FROM relatorios,aeronave 
			WHERE relatorios.cod_aeronave = aeronave.cod_aeronave 
			and callsign=$callsign";
	$res=$con->query($sql);
	$total = $res->num_rows;

	if ($res->num_rows>0){
		while ($row = $res->fetch_assoc()){
			$json[] = $row;
		}
	}

	//echo json_encode(array('total'=>$total,'rows'=>$json));
	echo json_encode($json);
 ?>