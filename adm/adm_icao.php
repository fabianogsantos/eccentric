<script language="javascript">
function filtro(what) { 
   if (what.selectedIndex != '') { 
      var opcao = what.value; 
      document.location=('index.php?pagina=adm_icao&icao=' + opcao); 
   } 
} 

</script>
<?php 

$icao = empty($_GET['icao'])?'':$_GET['icao'];

if ($icao<>"")
	$query_rs = "SELECT *  FROM icao where icao like'%$icao%' order by icao";
else 
	$query_rs = "SELECT *  FROM icao order by icao";
$rs = $con->query($query_rs);
$row_rs = $rs->fetch_assoc();
$totalRows_rs = $rs->num_rows;

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs = 30;
$pageNum_rs = 0;

if (isset($_GET['pageNum_rs'])) {
	$pageNum_rs = $_GET['pageNum_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs;

$query_limit_rs = sprintf("%s LIMIT %d, %d", $query_rs, $startRow_rs, $maxRows_rs);	
$rs = $con->query($query_limit_rs) ;
$row_rs = $rs->fetch_assoc();

if (isset($_GET['totalRows_rs'])) {
	$totalRows_rs = $_GET['totalRows_rs'];
} else {
	$all_rs = $con->query($query_rs);
	$totalRows_rs = $all_rs->num_rows;
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
<br />
<h3>Cadastro de Icaos</h3>
<hr />
<br />
<p>Pesquisar por ICAO:
    <input name="txtFiltro" type="text" id="txtFiltro" size="10" maxlength="5" onblur="filtro(this);"/> 
<em>Para pesquisar, digite parte do ICAO e aperte TAB.</em></p>
<br />
<input name="botInserir" type="button" value="Inserir" onclick="window.open('index.php?pagina=cad/incluiIcao','_self')"/>
<br /><br />
<table border="1" align="center">
  <tr>
  	<th><strong>Icao</strong></th>
    <th><strong>Nome</strong></th>
	<th colspan="3" align="center"><strong>Ações</strong></th>
  </tr>
  <?php 
  	do { 
    	echo "<td align=\"center\">".$row_rs['icao']."</td>
      			<td align=\"center\">".$row_rs['cidade']."</td>
	  			<td><a href=\"index.php?pagina=cad/cad_icao&icao=".$row_rs['icao']."\">&nbsp;Alterar&nbsp;</a></td></tr>";
    } while ($row_rs = $rs->fetch_assoc()); ?>
</table>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_rs > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, 0, $queryString_rs); ?>"><img src="imagens/diversos/FIRST.GIF" alt="Primeira p&aacute;gina" width="18" height="13" border="0"></a>      
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_rs > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, max(0, $pageNum_rs - 1), $queryString_rs); ?>"><img src="imagens/diversos/PREVIOUS.GIF" alt="Página anterior" width="18" height="13" border="0"></a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_rs < $totalPages_rs) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, min($totalPages_rs, $pageNum_rs + 1), $queryString_rs); ?>"><img src="imagens/diversos/NEXT.GIF" alt="Próxima p&aacute;gina" width="18" height="13" border="0"></a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_rs < $totalPages_rs) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, $totalPages_rs, $queryString_rs); ?>"><img src="imagens/diversos/LAST.GIF" alt="Última p&aacute;gina" width="18" height="13" border="0"></a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>	
