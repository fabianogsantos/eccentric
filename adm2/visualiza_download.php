<?php

$id = $_GET['id'];
$query_rsop = "SELECT * FROM downloads where id=$id";
$rsop = mysql_query($query_rsop) or die(mysql_error());
$row_rsop = mysql_fetch_assoc($rsop);
$totalRows_rsop = mysql_num_rows($rsop);
$piloto = $row_rsop['callsign'];

function mostraStatusDownload($status){
	switch($status){
		case "d":
			$retorno = "Dispon&iacute;vel";
			break;	
		case "c":
			$retorno = "Indispon&iacute;vel";
			break;		
	}	
	return $retorno;
}
?>
<h3>Dados do arquivo para Download</h3>
<hr color="#006600" />

<form name="dados_download" action="efetiva_download.php" method="post">
  <table align="center">
    <tr valign="baseline">
      <td width="193" align="right" nowrap><strong>Identifica&ccedil;&atilde;o:</strong></td>
      <td colspan="3"><? echo $row_rsop['id']; ?></td>
    </tr>  
    <tr valign="baseline">
      <td nowrap align="right"><strong>Descri&ccedil;&atilde;o:</strong></td>
      <td colspan="3"><input type="text" name="dsc" id="dsc" value="<? echo $row_rsop['dsc']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><strong>Callsign:</strong></td>
      <td colspan="3"><input type="text" name="callsign" id="callsign" value="<? echo $row_rsop['callsign']; ?>" /></td>
    </tr>  
    <tr valign="baseline">
      <td nowrap align="right"><strong>Nome do arquivo:</strong></td>
      <td colspan="3"><input type="text" name="nomearq" id="nomearq" value="<? echo $row_rsop['nome_arquivo']; ?>" /></td>
    </tr>      
    <tr valign="baseline">
      <td nowrap align="right"><strong>Data envio:</strong></td>
      <td colspan="3"><input type="text" name="dataupload" id="dataupload" value="<? echo ansi2br($row_rsop['data_upload']); ?>" /></td>
    </tr>	
	<tr valign="baseline">
	<td nowrap align="right"><strong>A&ccedil;&atilde;o:</strong></td>
	<td><select name="motivo" id="motivo">
		<option value="a" selected>Dispon&iacute;vel</option>
		<option value="a" selected>Indispon&iacute;vel</option>                
		</select>	</td>
	</tr>
   </table>
  <br />
  <input name="id" type="hidden" value="<? echo $row_rsop['id']; ?>" />
  <input name="butEnvia" type="submit" value="Gravar" />
</form>  
  <p>&nbsp;</p>
<?php
mysql_free_result($rsop);
?>