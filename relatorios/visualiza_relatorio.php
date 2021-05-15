
<head>
<style type="text/css">
.style1 {
	border: 1px solid #000000;
	border-collapse: collapse;
}
</style>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
</head>


<h3>Dados do relatório</h3>
<br />
<form name="dados_relatorio" action="../index.php?pagina=processaRelatorio" method="post">
  <table >
    <tr valign="baseline">
      <td width="193" align="right" nowrap style="font-weight: bold">N&uacute;mero do relat&oacute;rio:</td>
      <td colspan="2"><input name="txtNumeroRelatorio" type="hidden" value="<?php echo $row_rsrelatorio['numero']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap style="font-weight: bold">Callsign: </td>
      <td colspan="2"></td>
    </tr>  
    <tr valign="baseline">
      <td width="193" align="right" nowrap style="font-weight: bold">Modo:</td>
      <td colspan="2">
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Tipo do voo: </td>
      <td colspan="2">
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Número do voo:</td>
      <td colspan="2">
      					
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold"> Origem:</td>
      <td width="192">
      	
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Destino:</td>
      <td colspan="2">
      		
    </tr>
	    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Tempo de Voo:</td>
      <td colspan="2">
      			
    </tr>
	 <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Aeronave:</td>
      <td colspan="2">
      
    </td>
    </tr>
	
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Data Partida:</td>
      <td colspan="2">
	  			
    </tr>
    <!--<tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Hora Partida:</td>
      <td colspan="3">
      <?php
	  	/*
		if ($opcao==1)
			echo $row_rsrelatorio['hora_partida'];
		else 			
	       	echo "<input type=\"text\" name=\"txtHoraPartida\" id=\"txtHoraPartida\" value=\"".$row_rsrelatorio['hora_partida']."\"/></td\>";
		*/	
	  ?>	
    </tr> -->

	<tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Distância:</td>
      <td colspan="2">
      			
	</tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap style="font-weight: bold">Nível de vôo: </td>
      <td>
      			
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Combustível:</td>
      <td>
      			
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Plano de vôo:</td>
      <td>
      
      </td>
    </tr>
  
  </table>
<br/>
<table align="center" style="">
		<tr>
			<td align="center"></td>
			<td align="center"></td>			
			<td align="center"></td>
			<td align="center"></td>
		</tr>
	</table>
	<table align="center">
		<tr>
			<td align="center"></td>			
			<td align="center"></td>			
			<td align="center"></td>
		</tr>
	</table>
	<table align="center">
		<tr>
			<td align="center"></td>		
			<td align="center"></td>
			<td align="center"></td>
			<td align="center"></td>
			<td align="center"></td>
			<td align="center"></td>			
		</tr>
	</table>
</form>  
  <p>&nbsp;</p>
