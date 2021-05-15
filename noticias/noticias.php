<?php
		$link =  "noticias/cria_json.php";
?>

<h3 class="page-header">Notícias anteriores</h3>

<table id="table"
		data-toggle="table"
		data-pagination="true"
		data-search="true"
		data-url="<?=$link?>"
		>
	<thead>
		<th data-field="data_noticia" data-sortable="true">Data</th>
		<th data-field="texto">Texto</th>
	</thead>
</table>
