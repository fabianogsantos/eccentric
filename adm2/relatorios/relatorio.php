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

<div class="page-header">
	<h3>Dados do relat&oacute;rio</h3>
</div>

<form name="dados_relatorio" action="index.php?pagina=relatorios/processaRelatorio" method="post">
	<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<label for="numero">N&uacute;mero do relat&oacute;rio</label>
				<input name="numero" class="form-control" type="text" value="<?php echo $row['numero']; ?>" />
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="callsign">Callsign</label>
				<input name="callsign" class="form-control" type="text" value="<?php echo $row['callsign']; ?>">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<label for="modo">Modo</label>
				<select name="modo" class="form-control" >
					<option value="i" <?php if (!(strcmp("i", $row['modo']))) {echo "SELECTED";} ?>>Ivao</option>
					<option value="v" <?php if (!(strcmp("v", $row['modo']))) {echo "SELECTED";} ?>>Vatsim</option>
					<option value="o" <?php if (!(strcmp("o", $row['modo']))) {echo "SELECTED";} ?>>Offline</option>
				</select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="tipo">Tipo</label>
				<select name="tipo" class="form-control" >
					<option value="o" <?php if (!(strcmp("o", $row['tipo']))) {echo "SELECTED";} ?>>Oficial</option>
					<option value="e" <?php if (!(strcmp("e", $row['tipo']))) {echo "SELECTED";} ?>>Extra-oficial</option>
				</select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="numero_voo">Número</label>
				<input name="numero_voo" class="form-control" type="text" value="<?php echo $row['numero_voo']; ?>" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<label for="icao_origem">Origem</label>
				<input name="icao_origem" class="form-control" type="text" value="<?php echo $row['icao_origem'].'/'.getCidade($row['icao_origem'],$con); ?>" />
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="icao_destino">Destino</label>
				<input name="icao_destino" class="form-control" type="text" value="<?php echo $row['icao_destino'].'/'.getCidade($row['icao_destino'],$con); ?>" />
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="tempo_voo">Tempo de voo</label>
				<input name="tempo_voo" class="form-control" type="text" value="<?php echo $row['tempo_voo']; ?>" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<label for="cod_aeronave">Aeronave</label>
				<select name="cod_aeronave" class="form-control" >
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
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="data_partida">Data da partida</label>
				<input name="data_partida" class="form-control" type="text" value="<?php echo ansi2br($row['data_partida']); ?>" />
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="distancia">Distância</label>
				<input name="distancia" class="form-control" type="text" value="<?php echo $row['distancia']; ?>" />
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="altitude">Altitude</label>
				<input name="altitude" class="form-control" type="text" value="<?php echo $row['altitude']; ?>" />
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="combustivel">Combustível</label>
				<input name="combustivel" class="form-control" type="text" value="<?php echo $row['combustivel']; ?>" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<label for="plano_voo">Plano de voo</label>
				<select name="plano_voo" class="form-control" >
					<option value="fsn" <?php if (!(strcmp("fsn", $row['plano_voo']))) {echo "SELECTED";} ?>>FS Navigator</option>
					<option value="fs" <?php if (!(strcmp("fs", $row['plano_voo']))) {echo "SELECTED";} ?>>Flight Simulator</option>
					<option value="c" <?php if (!(strcmp("c", $row['plano_voo']))) {echo "SELECTED";} ?>>Cartas</option>
					<option value="r" <?php if (!(strcmp("r", $row['plano_voo']))) {echo "SELECTED";} ?>>Route Finder</option>
					<option value="o" <?php if (!(strcmp("o", $row['plano_voo']))) {echo "SELECTED";} ?>>Outros</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<label for="acao">Ação</label>
					<select name="acao" class="form-control" >
						<option value="2">Aprovar</option>
						<option value="3">Reprovar</option>
						<option value="4">Cancelar</option>
						<option value="5">Pendente</option>
					</select>
			</div>
		</div>
	</div>
	<input name="Gravar" class="btn btn-primary" type="submit" value="Gravar!">
</form>
