<script type="text/javascript">
function filtro(what) {
   if (what.selectedIndex != '') {
      var opcao = what.value;
      document.location=('index.php?pagina=op/ops&opcao=' + opcao);
   }
}

</script>

<?php

$opcao = empty($_GET["opcao"])?'':$_GET["opcao"];
if (@$opcao =="a"){
	$query_rs = "select * from op where status = 'a' order by data_pedido desc ";
	$res = $con->query($sql);
}
elseif ($opcao =="p"){
	$query_rs = "select * from op where status = 'p' order by data_pedido desc";
	$res = $con->query($sql);
}
elseif ($opcao =="r"){
	$query_rs = "select * from op where status = 'r' order by data_pedido desc";
	$res = $con->query($sql);
}
elseif ($opcao =="f"){
	$query_rs = "select * from op where status = 'f' order by data_pedido desc";
	$res = $con->query($sql);
}
elseif ($opcao =="t"){
	$query_rs = "select * from op order by data_pedido desc";
	$res = $con->query($sql);
}
else {
	$query_rs = "select * from op where status = 'p' order by data_pedido";
	$res = $con->query($sql);
}


$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs = 10;
$pageNum_rs = 0;

if (isset($_GET['pageNum_rs'])) {
	$pageNum_rs = $_GET['pageNum_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs;

$query_limit_rs = sprintf("%s LIMIT %d, %d", $query_rs, $startRow_rs, $maxRows_rs);
$rs = $con->query($query_limit_rs);
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
<h3>Ordens de Opera&ccedil;&atilde;o</h3>
<hr color="#009933">
  <label>Mostrar
  <select name="select" onChange="filtro(this);">
    <option value="">Filtre aqui</option>
    <option value="p" name="filtro">Aguardando</option>
    <option value="a" name="filtro">Aprovadas</option>
    <option value="f" name="filtro">Finalizadas</option>
    <option value="r" name="filtro">Reprovadas</option>
    <option value="c" name="filtro">Canceladas</option>
    <option value="t" name="filtro">Todas</option>
  </select>
  </label>
  <br />
  <br />
<?php
	if ($totalRows_rs>0)	{
?>
		<table border="1" align="center">
		  <tr>
		    <th>&nbsp;Id&nbsp;</th>
		    <th>&nbsp;Data Solic.&nbsp;</th>
		    <th>&nbsp;Callsign&nbsp;</th>
		    <th>&nbsp;N&uacute;m.Op.&nbsp;</th>
        <th>&nbsp;Status&nbsp;</th>
			  <th>&nbsp;A&ccedil;&otilde;es&nbsp;</th>
		  </tr>
	  <?php do { ?>
	    <tr>
        <td align="center"><?php echo $row_rs['id']; ?></td>
        <td align="center"><?php echo ansi2br($row_rs['data_pedido']); ?></td>
        <td align="center"><?php echo $row_rs['callsign']; ?></td>
        <td align="center"><?php echo $row_rs['num_op']; ?></td>
        <td align="center">&nbsp;<?php echo getStatusOp($row_rs['status']); ?>&nbsp;</td>
        <td><a href="index.php?pagina=op/visualiza_op&amp;id=<?php echo $row_rs['id']; ?>"><img src="imagens/icon_find.gif" alt="Ver os dados" /></a></td>
      </tr>
	    <?php } while ($row_rs = $rs->fetch_assoc()); ?>
	</table>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_rs > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, 0, $queryString_rs); ?>"><img src="imagens/First.gif" alt="Primeira p&aacute;gina" width="18" height="13" border="0"></a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_rs > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, max(0, $pageNum_rs - 1), $queryString_rs); ?>"><img src="imagens/Previous.gif" alt="Página anterior" width="18" height="13" border="0"></a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_rs < $totalPages_rs) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, min($totalPages_rs, $pageNum_rs + 1), $queryString_rs); ?>"><img src="imagens/Next.gif" alt="Próxima p&aacute;gina" width="18" height="13" border="0"></a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_rs < $totalPages_rs) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, $totalPages_rs, $queryString_rs); ?>"><img src="imagens/Last.gif" alt="Última p&aacute;gina" width="18" height="13" border="0"></a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<?php
	}
	else{
		echo "Não existem ordens de operação no momento.";
		}
?>
