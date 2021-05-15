<?php
	header('Content-type: application/json');
	include("../../conecta.php");

	$filtro = empty($_GET['filtro'])?'1':$_GET['filtro'];

	$sql = "SELECT relatorios.callsign,
        nome_guerra,
        numero,
				DATE_FORMAT(data_envio_relatorio,'%d/%m/%Y') as data_envio,
        nucleo,
				elt(field(relatorios.status,1,2,3,4,5),'Aguardando','Aprovado','Reprovado','Cancelado','Pendente') as status
			FROM relatorios
      JOIN piloto on relatorios.callsign = piloto.callsign
			WHERE relatorios.status = $filtro
      ORDER BY nucleo DESC, callsign ASC, numero ASC";
	$res=$con->query($sql);

	if ($res->num_rows>0){
		while ($row = $res->fetch_assoc()){
			//$json['data'][] = $row;
			$json[]=$row;
		}
	}

	//echo json_encode(array('total'=>$total,'rows'=>$json));
	echo json_encode($json);
 ?>
