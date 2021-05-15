<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		$callsign = $_SESSION['callsign'];
		$link =  "relatorios/cria_json.php?callsign=".$callsign;
?>

<h3 class="page-header">Relatórios Enviados <small>Consulte a tabela abaixo</small></h3>
<a class="btn btn-primary" href="index.php?pagina=relatorios/novo_relatorio" role="button">Clique aqui para enviar um novo relatório</a>

<table id="table"
		data-toggle="table" 
		data-pagination="true"
		data-search="true"
		data-url="<?=$link?>"
        data-sort-name="numero"
        data-sort-order="desc"
		>
	<thead>
		<th data-field="numero" data-sortable="true">Núm.</th>
		<th data-field="data_envio_relatorio" data-sortable="true">Data Envio</th>
		<th data-field="aeronave" data-sortable="true">Aeronave</th>
		<th data-field="numero_voo" data-sortable="true">Número Voo</th>
		<th data-field="icao_origem" data-sortable="true">ICAO Origem</th>
		<th data-field="icao_destino" data-sortable="true">ICAO Destino</th>
		<th data-field="data_partida" data-sortable="true">Data Partida</th>
		<th data-field="tempo_voo">Tempo Voo</th>
		<th data-field="status" data-sortable="true">Status</th>
	</thead>
</table>

<?php } ?>	

