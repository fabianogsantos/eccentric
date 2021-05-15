<?php

$id = $_GET['id'];
$query_rsop = "SELECT * FROM op where id=$id";
$rsop = $con->query($query_rsop);
$row_rsop = $rsop->fetch_assoc();
$totalRows_rsop = $rsop->num_rows;
$piloto = $row_rsop['callsign'];

$query_rsAnv = "SELECT * FROM aeronave where status='a'";
$rsAnv = $con->query($query_rsAnv);
$row_rsAnv = $rsAnv->fetch_assoc();
$totalRows_rsAnv = $rsAnv->num_rows;

$sql_posto = "select nome_posto from posto where cod_posto = (select cod_posto from piloto where callsign = $piloto)";
$res_posto = $con->query($sql_posto);
$row_posto = $res_posto->fetch_assoc();

?>
<h3>Dados da OP</h3>
<p>Abaixo est&atilde;o as informa&ccedil;&otilde;es da OP selecionada</p><hr color="#006600" />

<form name="dados_op" action="index.php?pagina=op/efetiva_op" method="post">
  <input name="id" type="hidden" value="<?php echo $row_rsop['id']; ?>" />
  <input name="callsign" type="hidden" value="<?php echo $row_rsop['callsign']; ?>" />
  <table align="center">
    <tr valign="baseline">
      <td width="193" align="right" nowrap><strong>Identifica&ccedil;&atilde;o:</strong></td>
      <td colspan="3"><input type="text" id="idop" name="idop" value="<?php echo $row_rsop['id']; ?>"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Rota:</strong></td>
      <td colspan="3"><textarea name="escalas" cols="30" rows="5"><?php echo $row_rsop['escalas']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><strong>Número de pernas:</strong></td>
      <td colspan="3"><input type="text" id="nropernas" name="nropernas" value="<?php echo $row_rsop['nropernas']; ?>"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><strong>Callsign:</strong></td>
      <td colspan="3"><input type="text" id="callsign" name="callsign" value="<?php echo $row_rsop['callsign']; ?>"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><strong>Posto:</strong></td>
      <td colspan="3"><?php echo $row_posto['nome_posto']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><strong>Data pedido:</strong></td>
      <td colspan="3"><input type="text" name="datapedido" id="datapedido" value="<?php echo ansi2br($row_rsop['data_pedido']); ?>"></td>
    </tr>
  	<tr valign="baseline">
      <td nowrap align="right"><strong>Aeronave:</strong></td>
	  <td colspan="3">
	  	<select name="cod_aeronave" id="cod_aeronave">
		<?php
			do {
				if ($row_rsop['cod_aeronave']==$row_rsAnv['cod_aeronave'])
					echo "<option value=\"".$row_rsAnv['cod_aeronave']."\" selected>".$row_rsAnv['nome']."</option>";
				else
					echo "<option value=\"".$row_rsAnv['cod_aeronave']."\">".$row_rsAnv['nome']."</option>";
			} while ($row_rsAnv = $rsAnv->fetch_assoc());
		?>
		</select>
		</td>
	</tr>
	<tr valign="baseline">
	<td nowrap align="right"><strong>A&ccedil;&atilde;o:</strong></td>
	<td><select name="motivo" id="motivo">
		<option value="a" selected>Aprovar</option>
    <option value="d">Apagar do BD</option>
		<option value="c">Cancelar</option>
		<option value="f">Finalizar</option>
		<option value="1">Reprovar - Preench. incorreto solicita&ccedil;&atilde;o</option>
		<option value="2">Reprovar - Posto do piloto n&atilde;o autorizado</option>
		<option value="3">Reprovar - Anv. incompat. com o posto</option>
		<option value="4">Reprovar - Anv. incompat. com algum aeroporto</option>
		<option value="5">Reprovar - Piloto tem outra rota n&atilde;o finalizada</option>
		<option value="6">Reprovar - Outros motivos</option>
		</select>	</td>
	</tr>
  <tr>
    <td colspan="2" align='center'><input name="butEnvia" type="submit" value="Efetivar dados" /></td>
  </tr>
   </table>
  <br />

</form>
