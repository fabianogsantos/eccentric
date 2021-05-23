<?php
if (!isset($_SESSION["callsign"])) {
	echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
} else {
	$callsign = $_SESSION['callsign'];
	$link =  "voos/get_json.php";
?>

	<h3 class="page-header">Cadastro de Voos</h3>
	<a class="btn btn-primary" href="index.php?pagina=voos/insere" role="button">Novo</a>

	<table id="table" data-row-style="rowStyle" data-pagination="True" data-page-size="20" data-toggle="table" data-pagination="true" data-search="true" data-url="<?= $link ?>" data-sort-name="num" data-formatter="LinkFormatterVoo">
		<thead>
			<tr>
				<th data-field="num" data-formatter="LinkFormatterVoo" data-sortable="true">Número</th>
				<th data-field="icaoorigem" data-sortable="true">ICAO Origem</th>
				<th data-field="icaodestino" data-sortable="true">ICAO Destino</th>
				<th data-field="vooanterior">Anterior</th>
				<th data-field="nucleo" data-sortable="true">Núcleo</th>
				<th data-field="nome_posto_curto" data-sortable="true">Posto</th>
			</tr>
		</thead>
	</table>

<?php } ?>