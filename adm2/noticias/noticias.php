<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		$callsign = $_SESSION['callsign'];
		$link =  "noticias/get_json.php";
?>

<h3 class="page-header">Cadastro de Notícias</h3>
<div id="toolbar">
    <a href="index.php?pagina=noticias/insere" class="btn btn-primary" role="button">Inserir</a>
</div>
<table id="table" 
		data-row-style="rowStyle" 
		data-pagination="True" 
		data-page-size="20"
		data-toggle="table" 
		data-pagination="true"
		data-search="true"
		data-url="<?=$link?>"
		data-formatter="LinkFormatter">	
	<thead>
		<tr>
			<th data-field="id" data-sortable="true" data-formatter="LinkFormatterIdNoticia">ID</th>
			<th data-field="data" data-sortable="true">Data</th>
			<th data-field="texto" data-formatter="substrTexto">Texto Inicial</th>
		</tr>
	</thead>
</table>

<?php } ?>