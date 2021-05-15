<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE voooficial SET icaoorigem=%s, icaodestino=%s, cidadeorigem=%s, cidadedestino=%s, nucleo=%s, posto=%s WHERE num=%s",
                       GetSQLValueString($_POST['icao_origem'], "text"),
                       GetSQLValueString($_POST['icao_destino'], "text"),
                       GetSQLValueString($_POST['cidade_origem'], "text"),
                       GetSQLValueString($_POST['cidade_destino'], "text"),
                       GetSQLValueString($_POST['sigla_nucleo'], "text"),
                       GetSQLValueString($_POST['cod_posto'], "int"),
                       GetSQLValueString($_POST['n_seq'], "text"));

  $Result1 = mysql_query($updateSQL) or die(mysql_error());

  $updateGoTo = "adm/adm_rotas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$query_rsRotas = "SELECT * FROM voooficial order by num";
$rsRotas = mysql_query($query_rsRotas, $conETR) or die(mysql_error());
$row_rsRotas = mysql_fetch_assoc($rsRotas);
$totalRows_rsRotas = mysql_num_rows($rsRotas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administra&ccedil;&atilde;o de Voos Oficiais - Altera&ccedil;&atilde;o</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Número:</td>
      <td><?php echo $row_rsRotas['n_seq']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Icao origem:</td>
      <td><input type="text" name="icao_origem" value="<?php echo htmlentities($row_rsRotas['icaoorigem'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Icao destino:</td>
      <td><input type="text" name="icao_destino" value="<?php echo htmlentities($row_rsRotas['icaodestino'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cidade origem:</td>
      <td><input type="text" name="cidade_origem" value="<?php echo htmlentities($row_rsRotas['cidadeorigem'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cidade destino:</td>
      <td><input type="text" name="cidade_destino" value="<?php echo htmlentities($row_rsRotas['cidadedestino'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Núcleo:</td>
      <td><input type="text" name="sigla_nucleo" value="<?php echo htmlentities($row_rsRotas['nucleo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Posto:</td>
      <td><input type="text" name="cod_posto" value="<?php echo htmlentities($row_rsRotas['posto'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Gravar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="n_seq" value="<?php echo $row_rsRotas['num']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsRotas);
?>
