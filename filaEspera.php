<?php
$currentPage = $_SERVER["PHP_SELF"];

function trataStatus($status){
	switch($status){
		case 1:
			$retorno = "Aguardando";
			break;
		case 2:
			$retorno = "Fila Espera";
			break;
		case 3:
			$retorno = "Convocado SP";
			break;
		case 4:
			$retorno = "Convocado RJ";
			break;
		case 5:
			$retorno = "Convocado RF";
			break;
		case 6:
			$retorno = "Menor";
			break;
		case 7:
			$retorno = "Incompleta";
			break;			
		case 8:
			$retorno = "Cancelado";
			break;
		case 10:
			$retorno = "Efetivado";
			break;									
	}
	return $retorno;
}


$maxRows_rs = 10;
$pageNum_rs = 0;

if (isset($_GET['pageNum_rs'])) {
	$pageNum_rs = $_GET['pageNum_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs;

$query_rs = "SELECT * from candidato where status=2";
$query_limit_rs = sprintf("%s LIMIT %d, %d", $query_rs, $startRow_rs, $maxRows_rs);	
$rs = mysql_query($query_limit_rs) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);

if (isset($_GET['totalRows_rs'])) {
	$totalRows_rs = $_GET['totalRows_rs'];
} else {
	$all_rs = mysql_query($query_rs);
	$totalRows_rs = mysql_num_rows($all_rs);
}
$totalPages_rs = ceil($totalRows_rs/$maxRows_rs)-1;

$queryString_rs = "";
if (!empty($_SERVER['QUERY_STRING'])) {
	$params = explode("&", $_SERVER['QUERY_STRING']);
	$newParams = array();
	foreach ($params as $param) {
		if (stristr($param, "pageNum_rs") == false &&
		stristr($param, "totalRows_rs") == false) {
			array_push($newParams, $param);
		}
	}
	if (count($newParams) != 0) {
		$queryString_rs = "&" . htmlentities(implode("&", $newParams));
	}
}
$queryString_rs = sprintf("&totalRows_rs=%d%s", $totalRows_rs, $queryString_rs);
?>
<h3>Fila de Espera da Eccentric Travels</h3>
<br />
<hr color="#009933">
<br />
<?
if ($totalRows_rs>0)
{
	?>
<table border="1" align="center">
	<tr>
		<th>Id</th>
		<th>Data Inscrição</th>
		<th>Nome de guerra</th>
		<th>Núcleo</th>
	</tr>
	<?php do { ?>
	<tr>
	    <? if (is_null($row_rs['data_convocacao']))
	    	$data_convoc ="-";
	       else 
	       	$data_convoc =ansi2br($row_rs['data_convocacao']);
	    ?>
		<td align="center"><?php echo $row_rs['num_candidato']; ?></td>
		<td align="center"><?php echo ansi2br($row_rs['data_inscricao']); ?></td>
		<td align="center"><?php echo $row_rs['nome_guerra']; ?></td>
		<td align="center"><?php echo $row_rs['nucleo']; ?></td>
	</tr>
	<?php } while ($row_rs = mysql_fetch_assoc($rs)); ?>
</table>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_rs > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, 0, $queryString_rs); ?>"><img src="imagens/diversos/FIRST.GIF" alt="Primeira p&aacute;gina" width="18" height="13" border="0"></a>      
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_rs > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, max(0, $pageNum_rs - 1), $queryString_rs); ?>"><img src="imagens/diversos/PREVIOUS.GIF" alt="P�gina anterior" width="18" height="13" border="0"></a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_rs < $totalPages_rs) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, min($totalPages_rs, $pageNum_rs + 1), $queryString_rs); ?>"><img src="imagens/diversos/NEXT.GIF" alt="Pr�xima p&aacute;gina" width="18" height="13" border="0"></a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_rs < $totalPages_rs) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, $totalPages_rs, $queryString_rs); ?>"><img src="imagens/diversos/LAST.gif" alt="�ltima p&aacute;gina" width="18" height="13" border="0"></a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>

	<?
}
else{
	echo "Não existem candidatos no momento.";
}
?>
