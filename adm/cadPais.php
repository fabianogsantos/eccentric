<?php
$codigo = $_GET['cod'];

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pais SET nome=%s, imagem=%s WHERE cod_pais=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['imagem'], "text"),
                       GetSQLValueString($_POST['cod_pais'], "int"));
  $Result1 = $con->query($updateSQL);
  ?><script language="Javascript">
	<!--
		alert("Dados atualizados!");
		window.open("index.php?pagina=../listaPais","_self");
	//-->
	</script>  
   <?    

}

$query_rsPais = "SELECT * FROM pais where cod_pais=$codigo";
$rsPais = $con->query($query_rsPais);
$row_rsPais = $rsPais->fetch_assoc();
$totalRows_rsPais = $rsPais->num_rows;
?>
<h3>Cadastro de Países</h3>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Código:</td>
      <td><?php echo $row_rsPais['cod_pais']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome:</td>
      <td><input type="text" name="nome" value="<?php echo htmlentities($row_rsPais['nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Arquivo da bandeira:</td>
      <td><input type="text" name="imagem" value="<?php echo htmlentities($row_rsPais['imagem'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Atualiza!" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="cod_pais" value="<?php echo $row_rsPais['cod_pais']; ?>" />
</form>
