<?php
include("../funcoes.php");
include("../conecta.php");

function runSQL($rsql) {
	$result = $con->query($rsql);
	return $result;
}

function countRec($fname,$tname) {
	$sql = "SELECT count($fname) FROM $tname ";
	$result = runSQL($sql);
	while ($row = $result->fetch_array()) {
		return $row[0];
	}
}
$callsign = $_GET['callsign'];
$page = $_POST['page'];
$rp = $_POST['rp'];
$sortname = $_POST['sortname'];
$sortorder = $_POST['sortorder'];

if (!$sortname) $sortname = 'numero';
if (!$sortorder) $sortorder = 'desc';

$sort = " ORDER BY $sortname $sortorder";

if (!$page) $page = 1;
if (!$rp) $rp = 10;

$start = (($page-1) * $rp);

$limit = "LIMIT $start, $rp";

$sql = "SELECT numero,data_envio_relatorio,cod_aeronave as aeronave,numero_voo,icao_origem,icao_destino,data_partida,tempo_voo,status FROM relatorios WHERE callsign=$callsign $sort $limit";
$result = runSQL($sql);

$total = countRec('numero','relatorios');

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-type: text/xml");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml .= "<rows>";
$xml .= "<page>$page</page>";
$xml .= "<total>$total</total>";
while ($row = mysql_fetch_array($result)) {
	$xml .= "<row id='".$row['numero']."'>";
	$xml .= "<cell><![CDATA[".$row['numero']."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode(ansi2br($row['data_envio_relatorio']))."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['numero_voo'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode(strtoupper($row['icao_origem']))."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode(strtoupper($row['icao_destino']))."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode(ansi2br($row['data_partida']))."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['aeronave'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['tempo_voo'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode(trataRelatorio($row['status']))."]]></cell>";
	$xml .= "</row>";
}

$xml .= "</rows>";
echo json_encode($xml);


?>