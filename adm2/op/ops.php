<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		$callsign = $_SESSION['callsign'];
		$filtro = empty($_GET['filtro'])?'p':$_GET['filtro'];
		$link =  "op/json.php?filtro=$filtro";
?>

<h3 class="page-header">Ordens de operação</h3>
<div class="row">
	<div id="toolbar">
		<select name="filtro_ops" id="filtro_ops" class="form-control">
			<option value="p" <?php if($filtro=='p') echo "selected"?>>Aguardando</option>
			<option value="a"<?php if($filtro=='a') echo "selected"?>>Aprovada</option>
			<option value="r"<?php if($filtro=='r') echo "selected"?>>Reprovada</option>
			<option value="c"<?php if($filtro=='c') echo "selected"?>>Cancelada</option>
			<option value="f"<?php if($filtro=='f') echo "selected"?>>Finalizada</option>
		</select>
	</div>
</div>

<table id="table" 
		data-row-style="rowStyle" 
		data-pagination="True" 
		data-page-size="20"
		data-toggle="table" 
		data-toolbar="#toolbar"
		data-search="true"
		data-url="<?=$link?>"
		data-formatter="LinkFormatter">	
	<thead>
		<tr>
			<th data-field="id" data-formatter="LinkFormatterOP">Id</th>
			<th data-field="_data_pedido">Data solicitção</th>
			<th data-field="callsign">Callsign</th>
			<th data-field="num_op" data-formatter="LinkFormatterOP">Número OP</th>
            <th data-fiels="_status">Status</th>
		</tr>
	</thead>
</table>
<?php } ?>