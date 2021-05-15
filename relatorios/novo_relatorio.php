<?php
if (!isset($_SESSION["callsign"])) {
?><script language="Javascript">
		window.open("index.php?pagina=pagina&pid=10", "_parent");
	</script><?php
				exit;
			}

			$callsign = $_SESSION["callsign"];
			$sql = "select * from piloto where callsign = $callsign";
			$res = $con->query($sql);
			$row = $res->fetch_assoc();
			$posto = $row["cod_posto"];
			$nucleo = $row["nucleo"];

			//verifica se tem alguma me ativa, se tem coloca na lista
			$sqlME = "SELECT * FROM me WHERE STATUS = 1";
			$resME = $con->query($sqlME);
			$rowME = $resME->fetch_assoc();
			$temME = $resME->num_rows;

			if ($temME > 0) {
				$nroPernasME =  formataNumero1($rowME['nropernas']);
				$codME = formataNumero1($rowME['cod']);
			} else

				$nroPernas = 0;
			//verifica se tem algum MP ativo, se tem coloca na lista
			$sqlMP = "SELECT * FROM mp WHERE STATUS = 1";
			$resMP = $con->query($sqlMP);
			$rowMP = $resMP->fetch_assoc();
			$temMP = $resMP->num_rows;

			if ($temMP > 0) {
				$nroPernas = formataNumero1($rowMP['nropernas']);
				$numeroMP = formataNumero1($rowMP['cod']);
			} else
				$nroPernas = 0;

			//verifica se tem alguma Revoada ativa, se tem coloca na lista
			$sqlRev = "SELECT * FROM rev WHERE STATUS = 1";
			$resRev = $con->query($sqlRev);
			$rowRev = $resRev->fetch_assoc();
			$temRev = $resRev->num_rows;

			if ($temRev > 0) {
				$nroPernas = formataNumero1($rowMP['nropernas']);
				$numeroRev = formataNumero1($rowRev['cod']);
			} else
				$nroPernas = 0;

			$sqlOP = "select * from op where status = 'a' and callsign=$callsign";
			$resOP = $con->query($sqlOP);
			$temOP = $resOP->num_rows;
			if ($temOP > 0) {
				$rowOP = $resOP->fetch_assoc();
				$numOP = $rowOP['num_op'];
				//$numeroPernasOp = formataNumero1($rowOP['nropernas']);
				$nroPernas = 65;
			}

			$sql = "select * from aeronave where cod_posto <= $posto and tipo_aeronave='p' union select * from aeronave where cod_posto <= $posto and tipo_aeronave='c' union select * from aeronave where cod_posto <= $posto and tipo_aeronave='t' order by nome";
			$resAeronave = $con->query($sql);
			$rowAeronave = $resAeronave->fetch_assoc();
				?>

<script>
	$(document).ready(function() {
		$("#tipo").change(function() {
			if ($("#tipo").val() == 'o') {
				$('#tipo_voo').load("relatorios/voosoficiais.php?callsign=<?php echo $callsign; ?>");
			} else {
				$('#tipo_voo').load("relatorios/voosextras.php?callsign=<?php echo $callsign; ?>");
			}
		});
	});
</script>

<h2 class="page-header">Envio de Relat&oacute;rio de Voo </h2>
<form class="form-horizontal" id="formrelatorio" name="formrelatorio" method="post" action="index.php?pagina=relatorios/recebeRelatorio">
	<div class="form-group">
		<label class="control-label col-sm-2" for="tempo_voo">Tempo de voo: </label>
		<div class="col-sm-2">
			<input class="form-control" type="time" name="tempo_voo" id="tempo_voo" required>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="data_partida">Data da partida: </label>
		<div class="col-sm-2">
			<input class="form-control" type="date" name="data_partida" id="data_partida" required>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="cod_aeronave">Aeronave: </label>
		<div class="col-sm-4">
			<select name="cod_aeronave" id="cod_aeronave" class="form-control" required>
				<option value="">Selecione</option>
				<?php
				do {
					echo "<option value=\"" . $rowAeronave['cod_aeronave'] . "\">" . $rowAeronave['nome'] . "</option>";
				} while ($rowAeronave = $resAeronave->fetch_assoc());
				$rows = $resAeronave->num_rows;
				if ($rows > 0) {
					$rowAeronave = $resAeronave->fetch_assoc($resAeronave);
				}
				?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="distancia">Dist&acirc;ncia (em nm): </label>
		<div class="col-sm-2">
			<input class="form-control" name="distancia" type="number" id="distancia" max=20000 required>
		</div>
	</div>

	<div class="form-group">
		<label for="altitude" class="control-label col-sm-2">N&iacute;vel de cruzeiro (FL):</label>
		<div class="col-sm-2">
			<input class="form-control" name="altitude" type="number" id="altitude" max=600 required>
		</div>
	</div>

	<div class="form-group">
		<label for="combustivel" class="control-label col-sm-2">Gal&otilde;es de combust&iacute;vel consumidos: </label>
		<div class="col-sm-2">
			<input class="form-control" name="combustivel" type="number" id="combustivel" required>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="plano">Plano de voo: </label>
		<div class="col-sm-4">
			<select name="plano" id="plano" class="form-control" required>
				<option value="">Selecione</option>
				<option value="fsn">FS Navigator</option>
				<option value="fs">Flight Simulator</option>
				<option value="c">Cartas</option>
				<option value="r">Route Finder</option>
				<option value="o">Outros </option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="modo">Modo: </label>
		<div class="col-sm-4">
			<select class="form-control" name="modo" id="modo" required>
				<option value="">Selecione</option>
				<option value="i">IVAO</option>
				<option value="v">Vatsim</option>
				<option value="o">Offline</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="tipo">Tipo: </label>
		<div class="col-sm-4">
			<select class="form-control" name="tipo" id="tipo" required>
				<option value="">Selecione</option>
				<option value="o">Oficial</option>
				<option value="e">Extra-oficial</option>
			</select>
		</div>
	</div>
	<div id="tipo_voo"></div>
	<div id="icaos"></div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<input type="submit" class="btn btn-primary" name="btnEnviar" id="btnEnviar" value="Enviar Relat&oacute;rio">
			<input type="reset" class="btn btn-danger" name="btnCancelar" id="btnCancelar" value="Cancelar">
		</div>
	</div>
</form>