<?php
header('Content-type: application/json');
include("../../conecta.php");

$query_rs = "SELECT v.num ,v.icaoorigem ,v.icaodestino,upper(v.nucleo) as nucleo,v.vooanterior,p.nome_posto_curto 
    from voooficial v , posto p 
    where v.posto = p.cod_posto 
    order by v.num";
$rs = $con->query($query_rs);
$row_rs = $rs->fetch_assoc();
$totalRows_rs = $rs->num_rows;

if ($rs->num_rows > 0) {
    while ($row = $rs->fetch_assoc()) {
        $json[] = $row;
    }
}
echo json_encode($json);
