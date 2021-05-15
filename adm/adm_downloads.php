<script type="text/javascript">
function confirmDelete()
{
    var agree=confirm("Os dados ser&atilde;o apagados. Confirma ?");
    if (agree)
        return true;
    else
        return false;
} 

function filtro(what) { 
   if (what.selectedIndex != '') { 
      var opcao = what.value; 
      document.location=('index.php?pagina=adm/adm_downloads&opcao=' + opcao); 
   } 
} 
		
</script>	

<?php 
$opcao = $_GET["opcao"];
if ($opcao =="d"){
	$query_rs = "select * from downloads where status = 'd' order by dsc";
	$res = mysql_query($sql);
}
elseif ($opcao =="i"){
	$query_rs = "select * from downloads where status='i' order by dsc";
	$res = mysql_query($sql);
}	
else {
	$query_rs = "select * from downloads order by dsc";
	$res = mysql_query($sql);	
}

function mostraStatusDownload($status){
	switch($status){
		case "d":
			$retorno = "Dispon&iacute;vel";
			break;	
		case "i":
			$retorno = "Indispon&iacute;vel";
			break;		
	}	
	return $retorno;
}
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs = 10;
$pageNum_rs = 0;

if (isset($_GET['pageNum_rs'])) {
	$pageNum_rs = $_GET['pageNum_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs;

$query_limit_rs = sprintf("%s LIMIT %d, %d", $query_rs, $startRow_rs, $maxRows_rs);	
$rs = mysql_query($query_limit_rs) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);

if (isset($_GET['totalRows_rs'])) {
	$totalRows_rs = $_GET['totalRows_rs'];
} else {
	$all_rs = mysql_query($query_rs);
	$totalRows_rs = mysql_num_rows($all_rs);
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
<h3>Downloads</h3>
<br />

<hr color="#009933">
<table>
  <tr>
    <td>Mostrar</td>
    <td><select name="select" onchange="filtro(this);">
      <option value="">Filtre aqui</option>
      <option value="d" name="filtro">Dispon&iacute;veis</option>
      <option value="i" name="filtro">Indispon&iacute;veis</option>
      <option value="t" name="filtro">Todos</option>
    </select></td>
    <td><input type="submit" name="enviarArquivo" id="enviarArquivo" onclick="window.open('index.php?pagina=formEnviaArquivo','_self')" value="Enviar outro arquivo" /></td>
  </tr>
</table>
<label></label>
  <br />
<?
	if ($totalRows_rs>0) 
	{
?>	
		<table border="1" align="center">
		  <tr>          
		    <th>&nbsp;Id&nbsp;</th>          
		    <th>&nbsp;Desc.&nbsp;</th>            
		    <th>&nbsp;Callsign&nbsp;</th>
		    <th>&nbsp;Data Envio&nbsp;</th>            
            <th>&nbsp;Status&nbsp;</th>
			<th colspan="3">&nbsp;A&ccedil;&otilde;es&nbsp;</th>
		  </tr>
	  <?php do { ?>
	    <tr>
          <td align="center"><?php echo $row_rs['id']; ?></td>        
	      <td align="center"><?php echo utf8_encode($row_rs['dsc']); ?></td>          
	      <td align="center"><?php echo $row_rs['callsign']; ?></td>
          <td align="center"><?php echo ansi2br($row_rs['data_upload']); ?></td>
	      <td align="center">&nbsp;<?php echo mostraStatusDownload($row_rs['status']); ?>&nbsp;</td>          
		  <td><a href="index.php?pagina=apaga_arquivo&amp;id=<? echo $row_rs['id']; ?>" onclick="return confirmDelete();"><img src="imagens/icon_del.gif" alt="Apagar" /></a></td>
		  <td><a href="index.php?pagina=visualiza_download&amp;id=<? echo $row_rs['id']; ?>"><img src="imagens/icon_find.gif" alt="Ver os dados" /></a></td></tr>
	    <?php } while ($row_rs = mysql_fetch_assoc($rs)); ?>
	</table>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_rs > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, 0, $queryString_rs); ?>"><img src="imagens/diversos/FIRST.GIF" alt="Primeira p&aacute;gina" width="18" height="13" border="0"></a>      
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_rs > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, max(0, $pageNum_rs - 1), $queryString_rs); ?>"><img src="imagens/diversos/PREVIOUS.GIF" alt="Página anterior" width="18" height="13" border="0"></a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_rs < $totalPages_rs) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, min($totalPages_rs, $pageNum_rs + 1), $queryString_rs); ?>"><img src="imagens/diversos/NEXT.GIF" alt="Próxima p&aacute;gina" width="18" height="13" border="0"></a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_rs < $totalPages_rs) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, $totalPages_rs, $queryString_rs); ?>"><img src="imagens/diversos/LAST.GIF" alt="Última p&aacute;gina" width="18" height="13" border="0"></a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>	
<?
	}
	else{
		echo "N&atilde;o existem arquivos de download.";
		}
?>		
