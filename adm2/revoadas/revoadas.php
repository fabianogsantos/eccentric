<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		$callsign = $_SESSION['callsign'];
		$link =  "revoadas/get_json.php";
?>

<h3 class="page-header">Cadastro de Revoadas</h3>
<a class="btn btn-primary" href="index.php?pagina=revoadas/insere" role="button">Novo</a>

<table id="table" 
		data-row-style="rowStyle" 
		data-pagination="True" 
		data-page-size="20"
		data-toggle="table" 
		data-pagination="true"
		data-search="true"
		data-url="<?=$link?>"
        data-sort-name="nome"
		data-formatter="LinkFormatterRev">	
	<thead>
		<tr>
			<th data-field="cod" data-sortable="true" data-formatter="LinkFormatterRev">Código</th>
			<th data-field="nome" data-sortable="true">Nome</th>
            <th data-field="imagem" data-formatter="LinkFormatterImgRev">Imagem</th>
		</tr>
	</thead>
</table>

<?php } ?>