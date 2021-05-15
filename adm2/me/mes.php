<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		$callsign = $_SESSION['callsign'];
		$link =  "me/get_json.php";
	
?>

<h3 class="page-header">Cadastro de Missões Especiais</h3>
<div id="toolbar">
    <a href="index.php?pagina=me/insere" class="btn btn-primary" role="button">Inserir</a>
</div>

<table id="table" 
		data-row-style="rowStyle" 
		data-pagination="True" 
		data-page-size="20"
		data-toggle="table" 
		data-pagination="true"
		data-search="true"
		data-url="<?=$link?>"
		data-formatter="LinkFormatterME"
		data-toolbar="#toolbar">	
	<thead>
		<tr>
			<th data-field="cod" data-sortable="true" data-formatter="LinkFormatterME">Código</th>
			<th data-field="nome" data-sortable="true">Nome</th>
            <th data-field="imagem" data-formatter="LinkFormatterImgME">Imagem</th>
		</tr>
	</thead>
</table>

<?php } ?>