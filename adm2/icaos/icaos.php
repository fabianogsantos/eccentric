<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		$callsign = $_SESSION['callsign'];
		$link =  "icaos/cria_json.php";
?>

<h3 class="page-header">Cadastro de ICAOs</h3>
<a class="btn btn-primary" href="index.php?pagina=icaos/insere" role="button">Novo ICAO</a>

<table id="table" 
		data-row-style="rowStyle" 
		data-pagination="True" 
		data-page-size="20"
		data-toggle="table" 
		data-pagination="true"
		data-search="true"
		data-url="<?=$link?>"
        data-sort-name="icao"
		data-formatter="LinkFormatter">	
	<thead>
		<tr>
			<th data-field="icao" data-sortable="true" data-formatter="LinkFormatter">ICAO</th>
			<th data-field="cidade" data-sortable="true">Aeródromo</th>
		</tr>
	</thead>
</table>

<?php } ?>