<?php
	header('Content-type: application/json');
	include("../../conecta.php");

	$filtro = empty($_GET['filtro'])?'1':$_GET['filtro'];

	$sql = "select num_candidato, date_format(data_inscricao,'%d/%m/%Y') as _data_inscricao, nome,nome_guerra,nucleo,
	case
	 	when status = 1 then 'Aguardando'
		when status = 2 then 'Fila Espera'
		when status = 3 then 'Convocado SP'
		when status = 4 then 'Convocado RJ'
		when status = 5 then 'Convocado RF'
		when status = 6 then 'Menor'
		when status = 7 then 'Incompleta'
		when status = 8 then 'Cancelado'
		when status = 10 then 'Efetivado'
	end as _status,date_format(data_convocacao,'%d/%m/%Y') as _data_convocacao from candidato
	where status = $filtro
	order by data_inscricao desc";
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