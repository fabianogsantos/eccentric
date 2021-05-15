<?
$icao = $_GET['icao'];

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
	if ($icao<>""){
	  $SQL = sprintf("UPDATE icao SET cidade=%s WHERE icao='$icao'",
                       GetSQLValueString($_POST['cidade'], "text"));
	}
	else {
	$SQL = sprintf("insert into icao (icao,cidade) values( %s,%s)",
                       GetSQLValueString($_POST['icao'], "text"),	
                       GetSQLValueString($_POST['cidade'], "text"));
	}		   
  $Result1 = mysql_query($SQL) or die(mysql_error());
  ?>
	<script language="Javascript">
	<!--
		alert("Dados enviados!");
		window.open("index.php?pagina=adm/adm_icao","_self");
	//-->
	</script>  
  <?  
}

$query_rs = "SELECT * FROM icao where icao='$icao'";
$rs = mysql_query($query_rs) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

$query_rsPosto = "SELECT * FROM posto";
$rsPosto = mysql_query($query_rsPosto) or die(mysql_error());
$row_rsPosto = mysql_fetch_assoc($rsPosto);
$totalRows_rsPosto = mysql_num_rows($rsPosto);
?>
<h3>Cadastro de Icaos</h3>
<hr />
<br />
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Icao:</strong></td>
      <td><input type="text" name="icao" value="<?php echo $row_rs['icao']; ?>" size="4"></td>
    </tr>  
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Cidade:</strong></td>
      <td><input name="cidade" type="text" id="cidade" value="<?php echo $row_rs['cidade']; ?>" size="70"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="Submit" type="submit" value="Gravar!"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
 </form>
<p>&nbsp;</p>
<?
mysql_free_result($rs);
?>
