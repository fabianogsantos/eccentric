<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
</head>

<script type="text/javascript">
function confirmDelete(){
    var agree=confirm("Os dados ser�o apagados. Confirma ?");
    if (agree)
        return true;
    else
        return false;
}

function filtro(what) {
   if (what.selectedIndex != '') {
      var opcao = what.value;
      document.location=('index.php?pagina=adm_relatorios&opcao=' + opcao);
   }
}
</script>

<?php
if(!isset($_SESSION["callsign"])){
	echo "<h3>Ops, sem logar n&atilde;o d&aacute;!</h3>";
	exit;
}
$callsign = $_SESSION["callsign"];

$op = empty($op)?1:$_GET['opcao'];

if (isset($_POST['select'])){
	$opcao = $_POST['select'];
	$etrFiltro = $_POST['filtro2'];
}
$query_rs = "select * from relatorios";

if (!empty($op)) $opcao = $op;

if ($opcao !=""){
	if (!empty($etrFiltro)){
		$query_rs = $query_rs." where callsign = $etrFiltro and status = '$opcao'";
	}
	else {
		$query_rs = $query_rs." where status = '$opcao'";
	}
}
else {
		if (!empty($etrFiltro)){
			$query_rs = $query_rs." where callsign = $etrFiltro and status=1";
		}
}
$query_rs = $query_rs." order by callsign, numero desc";
$res = $con->query($query_rs);

$_SERVER['QUERY_STRING'] = $query_rs;
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs = 5000;
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

$queryString_rs = $query_rs;
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
<h3>Relat&oacute;rios</h3>

<hr color="#009933"><br />
<div align="center">
  <form id="form1" name="form1" method="post" action="<?php echo $currentPage.'?pagina=adm_relatorios'; ?>">
Filtro por Status
    <select name="select">
  	<option value="">Selecione</option>
	<option value="1" name="filtro">Aguardando</option>
    <option value="2" name="filtro">Aprovados</option>
    <option value="3" name="filtro">Reprovados</option>
	<option value="4" name="filtro">Cancelados</option>
    <option value="5" name="filtro">Pendentes</option>
    <option value="9" name="filtro">Todos</option>
  </select>
  Filtro por Callsign
    <input name="filtro2" type="text" id="filtro2" size="6" />
    <input type="submit" name="butFiltro" id="butFiltro" value="Filtrar" />
</form>
</div>
  <br><br>
<?php
	if ($totalRows_rs>0)
	{
?>
		<table border="1" align="center">
		  <tr>
		    <th>Callsign</th>
		    <th>Nome</th>
		    <th>N&uacute;mero</th>
		    <th>Data Envio</th>
            <th>&nbsp;N&uacute;cleo&nbsp;</th>
            <th>Status</th>
			<th colspan="3">A&ccedil;&otilde;es</th>
		  </tr>
	  <?php do { ?>
	    <tr>
          <?php
		        $pil = $row_rs['callsign'];
			  	$query = "select nome_guerra, nucleo from piloto where callsign = $pil";
				$resQry = $con->query($query);
				$row = $resQry->fetch_assoc();
				$nomeGuerra = utf8_encode($row['nome_guerra']);
				$nuc = $row['nucleo'];
		  ?>
	      <td align="center"><?php echo $row_rs['callsign']; ?></td>
	      <td align="center"><?php echo " ".$nomeGuerra." "; ?></td>
	      <td align="center"><?php echo $row_rs['numero']; ?></td>
	      <td align="center"><?php echo ansi2br($row_rs['data_envio_relatorio']); ?></td>
	      <td align="center"><?php echo $nuc; ?></td>
	      <td align="center">&nbsp;<?php echo mostraStatus($row_rs['status']); ?>&nbsp;</td>
		  <td><a href="index.php?pagina=apaga_relatorio&amp;numero=<?php echo $row_rs['numero']; ?>" onclick="return confirmDelete();"><img src="imagens/icon_del.gif" alt="Apagar" /></a></td>
		  <td><a href="index.php?pagina=visualiza_relatorio&amp;numero=<?php echo $row_rs['numero']; ?>&amp;opcao=2"><img src="imagens/icon_find.gif" alt="Ver os dados" /></a></td>
		  </tr>
	    <?php } while ($row_rs = $rs->fetch_assoc()); ?>
	</table>

<?php
	}
	else{
		echo "N&atilde;o existem relat&oacute;rios no momento.";
		}
?>
