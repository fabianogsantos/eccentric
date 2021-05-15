<?
$anv = $_GET['cod_aeronave'];

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
	if ($anv!=0){
	  $SQL = sprintf("UPDATE aeronave SET nome=%s,prefixo=%s, nome_guerra=%s, data_inicio=%s, versao=%s, flg_aeronave_primaria=%s, cod_posto=%s, tipo_aeronave=%s, imagem_1=%s, nome_arq=%s, status=%s WHERE cod_aeronave=$anv",
                       GetSQLValueString($_POST['nome'], "text"),
					   GetSQLValueString($_POST['pref'], "text"),
                       GetSQLValueString($_POST['nome_guerra'], "text"),
                       GetSQLValueString(br2ansi($_POST['data_inicio']), "date"),
                       GetSQLValueString($_POST['versao'], "text"),
                       GetSQLValueString($_POST['flg_aeronave_primaria'], "text"),
                       GetSQLValueString($_POST['cod_posto'], "int"),
                       GetSQLValueString($_POST['tipo_aeronave'], "text"),
                       GetSQLValueString($_POST['imagem'], "text"),
                       GetSQLValueString($_POST['nome_arq'], "text"),
                       GetSQLValueString($_POST['status'], "text"));
	}
	else {
	$SQL = sprintf("insert into aeronave (cod_aeronave,nome,prefixo, nome_guerra, data_inicio, versao, flg_aeronave_primaria, cod_posto, tipo_aeronave, imagem_1, nome_arq, status) values( %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['cod_aeronave'], "text"),	
                       GetSQLValueString($_POST['nome'], "text"),
					   GetSQLValueString($_POST['pref'], "text"),
                       GetSQLValueString($_POST['nome_guerra'], "text"),
                       GetSQLValueString(br2ansi($_POST['data_inicio']), "date"),
                       GetSQLValueString($_POST['versao'], "text"),
                       GetSQLValueString($_POST['flg_aeronave_primaria'], "text"),
                       GetSQLValueString($_POST['cod_posto'], "int"),
                       GetSQLValueString($_POST['tipo_aeronave'], "text"),
                       GetSQLValueString($_POST['imagem'], "text"),
                       GetSQLValueString($_POST['nome_arq'], "text"),
                       GetSQLValueString($_POST['status'], "text"));
	//cria manual
	$sql1 = sprintf("insert into manual (cod_aeronave) values (%s)",GetSQLValueString($_POST['cod_aeronave'], "text"));
	$res1 = mysql_query($sql1) or die(mysql_error());
					   
	}		   
  $Result1 = mysql_query($SQL) or die(mysql_error());
  ?>
	<script language="Javascript">
	<!--
		alert("Dados enviados!");
		window.open("index.php?pagina=adm_aeronaves","_self");
	//-->
	</script>  
  <?  
}

$query_rsAeronaves = "SELECT * FROM aeronave where cod_aeronave=$anv";
$rsAeronaves = mysql_query($query_rsAeronaves) or die(mysql_error());
$row_rsAeronaves = mysql_fetch_assoc($rsAeronaves);
$totalRows_rsAeronaves = mysql_num_rows($rsAeronaves);

$query_rsPosto = "SELECT * FROM posto";
$rsPosto = mysql_query($query_rsPosto) or die(mysql_error());
$row_rsPosto = mysql_fetch_assoc($rsPosto);
$totalRows_rsPosto = mysql_num_rows($rsPosto);
?>
<h3>Cadastro de Aeronaves</h3>
<hr />
<br />
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>C&oacute;digo interno:</strong></td>
      <td><input type="text" name="cod_aeronave" value="<?php echo $row_rsAeronaves['cod_aeronave']; ?>" size="4"></td>
    </tr>  
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Prefixo:</strong></td>
      <td><input name="pref" type="text" id="pref" value="<?php echo $row_rsAeronaves['prefixo']; ?>" size="8"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Nome:</strong></td>
      <td><input type="text" name="nome" value="<?php echo $row_rsAeronaves['nome']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Nome de guerra:</strong></td>
      <td><input type="text" name="nome_guerra" value="<?php echo $row_rsAeronaves['nome_guerra']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Data de in&iacute;cio das opera&ccedil;&otilde;es:</strong></td>
      <td><input type="text" name="data_inicio" value="<?php echo ansi2br($row_rsAeronaves['data_inicio']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Vers&atilde;o:</strong></td>
      <td><input type="text" name="versao" value="<?php echo $row_rsAeronaves['versao']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>&Eacute; prim&aacute;ria ?:</strong></td>
      <td><select name="flg_aeronave_primaria">
        <option value="1" <?php if (!(strcmp(1, $row_rsAeronaves['flg_aeronave_primaria']))) {echo "SELECTED";} ?>>Sim</option>
        <option value="0" <?php if (!(strcmp(0, $row_rsAeronaves['flg_aeronave_primaria']))) {echo "SELECTED";} ?>>Não</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Posto habilitado para oper&aacute;-la:</strong></td>
      <td><select name="cod_posto">
        <?php 
do {  
?>
        <option value="<?php echo $row_rsPosto['cod_posto']?>" <?php if (!(strcmp($row_rsPosto['cod_posto'], $row_rsAeronaves['cod_posto']))) {echo "SELECTED";} ?>><?php echo $row_rsPosto['nome_posto_curto']?></option>
        <?php
} while ($row_rsPosto = mysql_fetch_assoc($rsPosto));
?>
      </select>      </td>
    <tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Tipo de aeronave:</strong></td>
      <td><select name="tipo_aeronave">
        <option value="p" <?php if (!(strcmp("p", $row_rsAeronaves['tipo_aeronave']))) {echo "SELECTED";} ?>>Passageiros</option>
        <option value="c" <?php if (!(strcmp("c", $row_rsAeronaves['tipo_aeronave']))) {echo "SELECTED";} ?>>Cargas</option>
        <option value="t" <?php if (!(strcmp("t", $row_rsAeronaves['tipo_aeronave']))) {echo "SELECTED";} ?>>Táxi aéreo</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong><a href="../index.php?pagina=formEnviaAeronave&amp;cod_aeronave=<? echo $row_rsAeronaves['cod_aeronave']; ?>">Imagem:</a></strong></td>
      <td><img src="<?php echo $dir_imagem_aeronaves.$row_rsAeronaves['../imagem_1']; ?>" /></td>
    </tr>
    
    
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Nome do arquivo de download:</strong></td>
      <td><input type="text" name="nome_arq" value="<?php echo $row_rsAeronaves['nome_arq']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Status:</strong></td>
      <td><select name="status">
        <option value="a" <?php if (!(strcmp("a", $row_rsAeronaves['status']))) {echo "SELECTED";} ?>>Ativa</option>
        <option value="i" <?php if (!(strcmp("i", $row_rsAeronaves['status']))) {echo "SELECTED";} ?>>Inativa</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="Submit" type="submit" value="Gravar!"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="imagem" value="<? echo $row_rsAeronaves['imagem_1']; ?> " />
  <input type="hidden" name="prefixo" value="<?php echo $row_rsAeronaves['prefixo']; ?>">
</form>
<p>&nbsp;</p>
<?
mysql_free_result($rsAeronaves);
mysql_free_result($rsPosto);
?>
