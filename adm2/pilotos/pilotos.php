<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		$callsign = $_SESSION['callsign'];
		$filtro = empty($_GET['filtro'])?'a':$_GET['filtro'];
		$link =  "pilotos/json.php?filtro=$filtro";
?>

<h3 class="page-header">Pilotos</h3>
<div class="row">
	<div id="toolbar">
		<select name="filtro_pilotos" id="filtro_pilotos" class="form-control">
			<option value="a"<?php if($filtro=='a') echo "selected"?>>Ativos</option>
			<option value="i"<?php if($filtro=='i') echo "selected"?>>Inativos</option>
		</select>
	</div>
</div>

<table id="table" 
		data-row-style="rowStyle" 
		data-pagination="True" 
		data-page-size="25"
		data-toggle="table" 
		data-search="true"
		data-url="<?=$link?>"
		data-toolbar="#toolbar"
		data-formatter="LinkFormatter">	
	<thead>
		<tr>
			<th data-field="callsign" data-formatter="LinkFormatterPiloto">Callsign</th>
			<th data-field="nome">Nome Guerra</th>
			<th data-field="status">Status</th>
			<th data-field="teste" data-formatter="linkAltDossie"></th>
		</tr>
	</thead>
</table>
<?php } ?>