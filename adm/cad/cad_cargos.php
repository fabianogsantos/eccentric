<?php require_once('../Connections/con1.php');

$cod_cargo = $_GET['cod_cargo'];


mysql_select_db($database_con1, $con1);
$query_rsCargos = "SELECT * FROM cargo where cod_cargo=$cod_cargo";
$rsCargos = mysql_query($query_rsCargos, $con1) or die(mysql_error());
$row_rsCargos = mysql_fetch_assoc($rsCargos);
$totalRows_rsCargos = mysql_num_rows($rsCargos);

mysql_free_result($rsCargos);
?>
<h3 align="center">Alteração do cadastro de cargos</h3>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right"><em><strong>C&oacute;digo</strong></em>:</td>
      <td><?php echo $row_rsCargos['cod_cargo']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><em><strong>Nome</strong></em>:</td>
      <td><input type="text" name="des_cargo" value="<?php echo $row_rsCargos['des_cargo']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><em><strong>Email</strong></em>:</td>
      <td><input type="text" name="email_cargo" value="<?php echo $row_rsCargos['email_cargo']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><em><strong>Descri&ccedil;&atilde;o</strong></em>:</td>
      <td><textarea name="texto" cols="50" rows="10"><?php echo $row_rsCargos['texto']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Atualizar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="cod_cargo" value="<?php echo $row_rsCargos['cod_cargo']; ?>">
</form>
<p align="center">
  <?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE cargo SET des_cargo=%s, email_cargo=%s, texto=%s WHERE cod_cargo=%s",
                       GetSQLValueString($_POST['des_cargo'], "text"),
                       GetSQLValueString($_POST['email_cargo'], "text"),
                       GetSQLValueString($_POST['texto'], "text"),
                       GetSQLValueString($_POST['cod_cargo'], "int"));

  mysql_select_db($database_con1, $con1);
  $Result1 = mysql_query($updateSQL, $con1) or die(mysql_error());
  ?><script language="Javascript">
	alert('Dados alterados!');
	window.open("index.php?pagina=adm_cargos","_parent");
	</script>
	<?
}

?>

  <br />
Após a criação de um cargo, para o piloto receber emails do seu cargo, é necessário criar uma conta de email para o novo cargo no host que hospeda a página da ETR.</p>

