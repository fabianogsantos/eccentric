<?php
if (!isset($_SESSION["callsign"])) {
	echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
} else {
	$callsign = $_SESSION['callsign'];
	$filtro = empty($_GET['filtro']) ? '1' : $_GET['filtro'];
	$link =  "relatorios/json.php?filtro=$filtro";
?>

	<h3 class="page-header">Relatórios</h3>
	<div class="row">
		<div id="toolbar">
			<select name="filtro_relatorios" id="filtro_relatorios" class="form-control">
				<option value="1" <?php if ($filtro == 1) echo "selected" ?>>Aguardando</option>
				<option value="2" <?php if ($filtro == 2) echo "selected" ?>>Aprovado</option>
				<option value="3" <?php if ($filtro == 3) echo "selected" ?>>Reprovado</option>
				<option value="4" <?php if ($filtro == 4) echo "selected" ?>>Cancelado</option>
				<option value="5" <?php if ($filtro == 5) echo "selected" ?>>Pendente</option>
			</select>
		</div>
	</div>

	<table id="table" data-page-size="25" data-toggle="table" data-pagination="true" data-search="true" data-url="<?= $link ?>" data-formatter="LinkFormatter" data-toolbar="#toolbar" data-show-refresh="true">
		<thead>
			<tr>
				<th data-field="nucleo">Núcleo</th>
				<th data-field="callsign" data-sortable="true">Callsign</th>
				<th data-field="numero" data-sortable="true" data-formatter="LinkFormatterNroRelatorio">Número</th>
				<th data-field="data_envio" data-sortable="true">Data Envio</th>
				<th data-field="nome_guerra" data-sortable="true">Nome Guerra</th>
				<th data-field="status">Status</th>
			</tr>
		</thead>
	</table>
<?php } ?>