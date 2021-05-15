
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
</head>

<?php
$cod = $_GET['cod'];
$acao = $_GET['acao'];
$conf = $_GET['conf'];

if (isset($cod)){
    $query = "SELECT * FROM me where cod=$cod";
    $rs = mysql_query($query) or die(mysql_error());
    $row = mysql_fetch_assoc($rs);
    $totalRows = mysql_num_rows($rs);
}

if ($acao=='del' && $conf=='s'){
    $sql = 'delete from me where cod='.$cod;
    $res = mysql_query($sql) or die(mysql_error());
    ?>
	<script language="Javascript">
		alert("Apagou!");
		window.open("index.php?pagina=adm/adm_MEs","_self");
	</script>  
<?php
}


if ($acao=='ina'){
    $sql = 'update me set status =0 where cod='.$cod;
    $res = mysql_query($sql);
	?>
	<script language="Javascript">
		alert("Gravou!");
		window.open("index.php?pagina=adm/adm_MEs","_self");
	</script>  
<?php	
}

if ($acao=='ati'){
    $sql = 'update me set status =1 where cod='.$cod;
    $res = mysql_query($sql);
?>
	<script language="Javascript">
		alert("Gravou!");
		window.open("index.php?pagina=adm/adm_MEs","_self");
	</script>  
<?php
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
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
	  $SQL = sprintf("UPDATE me SET nome=%s, imagem=%s, status=%s, nropernas=%s WHERE cod=$cod",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['imagem'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['nropernas'], "text"));
	}
	else {
		if (empty($_POST['imagem']))
			$imagem = 'me0.jpg';
		else 
		    $imagem = $_POST['imagem'];
		$SQL = sprintf("insert into me (nome, imagem, status,nropernas) values( %s,'$imagem',%s,%s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['nropernas'], "text"));					   
	}	
  $Result1 = mysql_query($SQL) or die(mysql_error());
  ?>
	<script language="Javascript">
		alert("Gravou!");
		window.open("index.php?pagina=adm/adm_MEs","_self");
	</script>  
  <?php
}

if ($cod==0){
	$sql1 = "select max(cod) as maxi from me";
	$rs = mysql_query($sql1);
	$row=mysql_fetch_assoc($rs);
	$novoCodigo = $row['maxi'];
	$novoCodigo = $novoCodigo+1;
}

?>
<?php
  if ($cod==0)
     echo "<h3>Cadastro de NOVA Miss&atilde;o Especial</h3>";
  else
      if ($acao!='del')
        echo "<h3>Cadastro de Miss&atilde;o Especial - Altera&ccedil;&atilde;o</h3>";
?>	 
<br />
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<?php
    if ($acao!='del'){
?>
  <table align="center">
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>C&oacute;digo:</strong></td>
      <?php
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
      <?php
	  	if ($cod==0)
			echo "<td><input name=\"imagem\" type=\"text\" /><a href=\"index.php?pagina=formEnviaArquivo\">Clique aqui para enviar uma imagem</a></td>";
		else 
		    echo "<td><input name=\"imagem\" type=\"text\" readonly=\"true\" value=\"".$row['imagem']."\"/><br/><a href=\"index.php?pagina=formEnviaArquivo\"><img src=\"".$dir_imagem_me.$row['imagem']."\" width=\"410\"/></a><br/>Clique na imagem acima para alterar. N&atilde;o &eacute; poss&iacute;vel alterar pelo nome.</td>";
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
      <td align="right" valign="top" nowrap><strong>Número de pernas:</strong></td>
      <td><input type="text" name="nropernas" value="<?php echo $row['nropernas']; ?>" size="10"></td>>
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="Submit" type="submit" value="Gravar!"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
<?php }
else {
    echo 'Tem certeza que deseja excluir a ME: '.$row['cod'].' - '.$row['nome'].'? <br/><strong>Esta ação é irreversível.</strong>';
    echo '<br/>';
    echo '<a href="'.$_SERVER['PHP_SELF'].'?pagina=adm/cad_ME&cod='.$cod.'&acao=del&conf=s"><img src="imagens/diversos/ok.gif" alt="Sim" /></a>&nbsp;';
    echo '<a href="'.$_SERVER['PHP_SELF'].'?pagina=adm/cad_ME&cod='.$cod.'&acao=del&conf=n"><img src="imagens/diversos/op_rejeitada.gif" alt="N$atilde;o" /></a>&nbsp;';
}
?>
</form>
<p>&nbsp;</p>


<?php
    mysql_free_result($rs);
?>
