<?php
if ($_SERVER['REQUEST_METHOD']=='GET'&&!empty($_GET['opcao'])){
  if ($_GET['opcao']=='del'){
    $numero = $_GET['id'];
    $sql = "delete from noticia where id=$numero";
    $res = $con->query($sql);
    ?><script language="Javascript">
      alert("Notícia apagada forever!");
    </script>
    <?php
  }
}



if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 15;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$query_Recordset1 = "SELECT * FROM noticia where data > '2017-07-21' ORDER BY data DESC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);

$Recordset1 = $con->query($query_limit_Recordset1) or die(mysql_error());
$row_Recordset1 = $Recordset1->fetch_assoc();

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = $con->query($query_Recordset1);
  $totalRows_Recordset1 = $all_Recordset1->num_rows;
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<h3>Cadastro de Not&iacute;cias</h3>
<input name="botInserir" type="button" value="Inserir" onclick="window.open('index.php?pagina=cad/cad_noticia2&opcao=ins&num=0','_self')"/>
<br /><br />
<table border="1" align="center">
  <tr>
    <th>&nbsp;N&uacute;mero&nbsp;</th>
    <th>&nbsp;Data&nbsp;</th>
    <th>&nbsp;Conteúdo&nbsp;</th>    
    <th>&nbsp;A&ccedil;&otilde;es&nbsp;</th>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center"><?php echo $row_Recordset1['id']; ?></td>
      <td align="center">&nbsp;<?php echo ansi2br($row_Recordset1['data']); ?>&nbsp;</td>
      <td><?php echo substr($row_Recordset1['texto'],0,20);?></td>
      <td>&nbsp;<a href="index.php?pagina=cad/cad_noticia2&opcao=''&num=<?php echo $row_Recordset1['id']; ?>" ><img src="imagens/icon_find.gif" alt="Ver os dados" /></a> &nbsp;<a href="index.php?pagina=adm_noticias&opcao=del&id=<?php echo $row_Recordset1['id']; ?>" onclick="return confirmDelete();"><img src="imagens/icon_del.gif" alt="Apagar" /></a></td>     
    </tr>
    <?php } while ($row_Recordset1 = $Recordset1->fetch_assoc()); ?>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="imagens/First.gif" /></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="imagens/Previous.gif" /></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="imagens/Next.gif" /></a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="imagens/Last.gif" /></a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
</p>



