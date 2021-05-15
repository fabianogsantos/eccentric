<?php
	header('Content-type: application/json');
	include("../../conecta.php");

	$filtro = empty($_GET['filtro'])?'p':$_GET['filtro'];


    $sql = "select id,num_op, callsign, date_format(data_pedido,'%d/%m/%Y') as _data_pedido, 
    case 
    when status='p' then 'Aguardando'
    when status='a' then 'Aprovada'
    when status='r' then 'Reprovada'
    when status='c' then 'Cancelada'
    when status='f' then 'Finalizada'
	end as _status from op 
	where status = '$filtro'
	order by data_pedido desc";
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
