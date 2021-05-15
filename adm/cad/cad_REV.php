<?
$cod = $_GET['cod_rev'];

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
	if ($cod!=0){
	  $SQL = sprintf("UPDATE rev SET nome=%s, imagem=%s, status=%s WHERE cod=$cod",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['imagem'], "text"),
                       GetSQLValueString($_POST['status'], "text"));
	}
	else {
		if (empty($_POST['imagem']))
			$imagem = 'rev0.jpg';
		else
		    $imagem = $_POST['imagem'];
		$SQL = sprintf("insert into rev (nome, imagem, status) values( %s,'$imagem',%s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['status'], "text"));
	}
  $Result1 = mysql_query($SQL) or die(mysql_error());
  ?>
	<script language="Javascript">
	<!--
		alert("Dados enviados!");
		window.open("index.php?pagina=adm/adm_REV","_self");
	//-->
	</script>
  <?
}

if ($cod==0){
	$sql1 = "select max(numero) as maxi from rev";
	$rs = $con->query($sql1);
	$numLin = $rs->num_rows;

	if ($numLin>0){
		$row=$rs->fetch_assoc();
		$novoCodigo = $row['maxi'];
		$novoCodigo = $novoCodigo+1;
	}
	else {
		$novoCodigo="1";
	}
}


$query = "SELECT * FROM rev where cod=$cod";
$rs2 = $con->query($query);
$totalRows = $rs2->num_rows;

if ($totalRows>0) $row = $rs2->fetch_assoc();


if ($cod==0)
    echo "<h3>Cadastro de NOVA Revoada</h3>";
else
     echo "<h3>Cadastro de Revoada - Altera&ccedil;&atilde;o</h3>";
?>
<br />
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>C&oacute;digo:</strong></td>
      <?
	  	if ($cod==0)
			echo "<td>".$novoCodigo."</td>";
		else
			echo "<td>".$row['cod']."</td>";
	   ?>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Nome:</strong></td>
      <td><input type="text" name="nome" value="<?php echo $row['nome']; ?>" size="60"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Imagem:</strong></td>
      <?
	  	if ($cod==0)
			echo "<td><input name=\"imagem\" type=\"text\" /><a href=\"index.php?pagina=formEnviaArquivo\">Clique aqui para enviar uma imagem</a></td>";
		else
		    echo "<td><input name=\"imagem\" type=\"text\" value=\"".$row['imagem']."\"/><br/><a href=\"index.php?pagina=formEnviaArquivo\"><img src=\"".$dir_imagem_rev.$row['imagem']."\" width=\"410\"/></a><br/>Clique na imagem acima para alterar. N&atilde;o &eacute; poss&iacute;vel alterar pelo nome.</td>";
	  ?>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Status:</strong></td>
      <td><select name="status">
        <option value="1" <?php if (!(strcmp("1", $row['status']))) {echo "SELECTED";} ?>>Ativa</option>
        <option value="0" <?php if (!(strcmp("0", $row['status']))) {echo "SELECTED";} ?>>Inativa</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>N&ugrave;mero de pernas:</strong></td>
      <td><input type="text" name="nropernas" value="<?php echo $row['nropernas']; ?>" size="2"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="Submit" type="submit" value="Gravar!"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
