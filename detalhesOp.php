<?php

$num_op = $_GET['num_op'];
$query_rsop = "SELECT * FROM op where num_op=$num_op";
$rsop = mysql_query($query_rsop) or die(mysql_error());
$row_rsop = mysql_fetch_assoc($rsop);
$totalRows_rsop = mysql_num_rows($rsop);
$piloto = $row_rsop['callsign'];

$query_rsAnv = "SELECT * FROM aeronave where status='a'";
$rsAnv = mysql_query($query_rsAnv) or die(mysql_error());
$row_rsAnv = mysql_fetch_assoc($rsAnv);
$totalRows_rsAnv = mysql_num_rows($rsAnv);

function trataMotivo($sta){
	switch ($sta){
		case "x":
			$estado = "OP Aprovada";
			break;
		case "a":
			$estado = "Preenchimento incorreto da solicitação";
			break;
		case "b":
			$estado = "Posto do piloto não autorizado";
			break;
		case "c":
			$estado = "Aeronave incompat. com o posto do piloto";
			break;
		case "d":
			$estado = "Aeron. incompat. com algum aeroporto da rota";
			break;
		case "e":
			$estado = "Piloto tem outra rota ainda não finalizada";
			break;
		case "f":
			$estado = "Outros motivos";
			break;
		default:			
			$estado = "OP Aprovada";
			break;
		
	}
	return $estado;
}

function trataStatus($sta){
	switch ($sta){
		case "a":
			$estado = "OP Aprovada";
			break;
		case "r":
			$estado = "REPROVADA";
			break;
		case "c":
			$estado = "Cancelada";
			break;
		case "f":
			$estado = "Finalizada";
			break;	
	}
	return $estado;
}
?>
<h3>Dados da OP</h3>
<p>Abaixo estão as informações da OP selecionada</p><hr color="#006600" />
  <table align="center">
    <tr valign="baseline">
      <td align="right" nowrap><strong>Número da OP:</strong></td>
      <td colspan="3"><? echo $row_rsop['num_op']; ?></td>
    </tr>  
    

    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Rota:</strong></td>
      <td colspan="3"><textarea name="escalas" cols="45" rows="10"><? echo $row_rsop['escalas']; ?></textarea></td>
    </tr>  
    <tr valign="baseline">
      <td nowrap align="right"><strong>Data pedido:</strong></td>
      <td colspan="3"><? echo ansi2br($row_rsop['data_pedido']); ?></td>
    </tr>
  	<tr valign="baseline">
      <td nowrap align="right"><strong>Aeronave:</strong></td>
      <td colspan="3">
            <?php
				$anv = $row_rsop['cod_aeronave'];
				$sql = "select nome from aeronave where cod_aeronave='$anv'";
				$res = mysql_query($sql);
				$row = mysql_fetch_assoc($res);
				echo $row['nome'];
			?>			</td>
	</tr>
    <tr valign="baseline">
      <td nowrap align="right"><strong>Situação:</strong></td>
      <td colspan="3"><? echo trataStatus(($row_rsop['status'])); ?></td>
    </tr>
    <?
	if ($row_rsop['status']<>'a') 
    	echo "<tr valign=\"baseline\">
              <td nowrap align=\"right\"><strong>Motivo:</strong></td>
              <td colspan=\"3\">".trataMotivo($row_rsop['motivo'])."</td>
              </tr>";
	?>
  </table>
<label></label>
  <p>&nbsp;</p>
<?php
mysql_free_result($rsop);

mysql_free_result($rsAnv);
?>