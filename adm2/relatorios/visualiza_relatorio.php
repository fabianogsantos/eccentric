<?php
	if(!isset($_SESSION["callsign"])){
		?><script language="Javascript">
				window.open("index.php","_parent");
		</script><?php
    	exit;
	}
	$callsign = $_SESSION["callsign"];


	$numero = $_GET['numero'];
	$sql = "select * from relatorios where numero=$numero";
	$res = $con->query($sql) ;
	$row = $res->fetch_assoc();

	$sql = "SELECT * FROM aeronave";
	$resAeronaves = $con->query($sql) ;
?>

<h3>Dados do relat&oacute;rio</h3>
<br />
<form name="dados_relatorio" action="index.php?pagina=relatorios/processaRelatorio" method="post">
  <table >
    <tr valign="baseline">
      <td width="193" align="right" nowrap style="font-weight: bold">N&uacute;mero do relat&oacute;rio:</td>
      <td colspan="2"><input name="numero" type="text" value="<?php echo $row['numero']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap style="font-weight: bold">Callsign: </td>
      <td colspan="2"><input name="callsign" type="text" size="3" value="<?php echo $row['callsign']; ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td width="193" align="right" nowrap style="font-weight: bold">Modo:</td>
      <td colspan="2"><select name="modo">
        <option value="i" <?php if (!(strcmp("i", $row['modo']))) {echo "SELECTED";} ?>>Ivao</option>
        <option value="v" <?php if (!(strcmp("v", $row['modo']))) {echo "SELECTED";} ?>>Vatsim</option>
        <option value="o" <?php if (!(strcmp("o", $row['modo']))) {echo "SELECTED";} ?>>Offline</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Tipo do voo: </td>
      <td colspan="2">
      <select name="tipo">
        <option value="o" <?php if (!(strcmp("o", $row['tipo']))) {echo "SELECTED";} ?>>Oficial</option>
        <option value="e" <?php if (!(strcmp("e", $row['tipo']))) {echo "SELECTED";} ?>>Extra-oficial</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">N&uacute;mero do voo:</td>
      <td colspan="2">
		<input name="numero_voo" type="text" value="<?php echo $row['numero_voo']; ?>" />
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold"> Origem:</td>
        <td colspan="2"><input name="icao_origem" type="text" value="<?php echo $row['icao_origem'].'/'.getCidade($row['icao_origem'],$con); ?>" />
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Destino:</td>
      <td colspan="2"><input name="icao_destino" type="text" value="<?php echo $row['icao_destino'].'/'.getCidade($row['icao_destino'],$con); ?>" />
    </tr>
	    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Tempo de Voo:</td>
      <td colspan="2"><input name="tempo_voo" type="text" value="<?php echo $row['tempo_voo']; ?>" />
    </tr>
	 <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Aeronave:</td>
      <td colspan="2"><select name="cod_aeronave">
      <?php
      	while ($rowAeronaves = $resAeronaves->fetch_assoc()){
      		if($rowAeronaves['cod_aeronave']==$row['cod_aeronave'])
      			$sel=" SELECTED";
      		else
	      		$sel="";
      		echo "<option value=\"".$rowAeronaves['cod_aeronave']."\"".$sel.">".getAeronave($rowAeronaves['cod_aeronave'],$con)."</option>";
      	}
      ?>
      </select>
    </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Data Partida:</td>
      <td colspan="2"><input name="data_partida" type="text" value="<?php echo ansi2br($row['data_partida']); ?>" />
    </tr>
	<tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Dist&acirc;ncia:</td>
      <td colspan="2"><input name="distancia" type="text" value="<?php echo $row['distancia']; ?>" />
	</tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap style="font-weight: bold">N&iacute;vel de voo: </td>
      <td><input name="altitude" type="text" value="<?php echo $row['altitude']; ?>" />
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Combust&iacute;vel:</td>
      <td><input name="combustivel" type="text" value="<?php echo $row['combustivel']; ?>" />
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Plano de voo:</td>
      <td><select name="plano_voo">
        <option value="fsn" <?php if (!(strcmp("fsn", $row['plano_voo']))) {echo "SELECTED";} ?>>FS Navigator</option>
        <option value="fs" <?php if (!(strcmp("fs", $row['plano_voo']))) {echo "SELECTED";} ?>>Flight Simulator</option>
        <option value="c" <?php if (!(strcmp("c", $row['plano_voo']))) {echo "SELECTED";} ?>>Cartas</option>
        <option value="r" <?php if (!(strcmp("r", $row['plano_voo']))) {echo "SELECTED";} ?>>Route Finder</option>
        <option value="o" <?php if (!(strcmp("o", $row['plano_voo']))) {echo "SELECTED";} ?>>Outros</option>
      </select>       </td>
    </tr>
	<tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">A&ccedil;&atilde;o:</td>
      <td><select name="acao">
			<option value="2">Aprovar</option>
			<option value="3">Reprovar</option>
			<option value="4">Cancelar</option>
			<option value="5">Pendente</option>
			</select>
      </td>
    </tr>
	<tr valign="baseline">
      <td>&nbsp;</td><td><input name="Gravar" type="submit" value="&nbsp;&nbsp;&nbsp;Gravar!&nbsp;&nbsp;&nbsp;"></td>
    </tr>
  </table>
	<br>
</form>
