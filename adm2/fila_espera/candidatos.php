<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		$callsign = $_SESSION['callsign'];
		$filtro = empty($_GET['filtro'])?'1':$_GET['filtro'];
		$link =  "fila_espera/json.php?filtro=$filtro";
?>

<h3 class="page-header">Cadastro de Candidatos</h3>
<div class="row">
	<div id="toolbar">
		<select name="filtro_filaespera" id="filtro_filaespera" class="form-control">
			<option value="1" <?php if($filtro==1) echo "selected"?>>Aguardando</option>
			<option value="2"<?php if($filtro==2) echo "selected"?>>Fila de espera</option>
			<option value="3"<?php if($filtro==3) echo "selected"?>>Convocado SP</option>
			<option value="4"<?php if($filtro==4) echo "selected"?>>Convocado RJ</option>
			<option value="5"<?php if($filtro==5) echo "selected"?>>Convocado RF</option>
			<option value="6"<?php if($filtro==6) echo "selected"?>>Menor</option>
			<option value="7"<?php if($filtro==7) echo "selected"?>>Incompleta</option>
			<option value="8"<?php if($filtro==8) echo "selected"?>>Cancelado</option>
			<option value="10"<?php if($filtro==10) echo "selected"?>>Efetivo</option>
		</select>
	</div>
</div>

<table id="table" 
		data-row-style="rowStyle" 
		data-pagination="True" 
		data-page-size="20"
		data-toggle="table" 
		data-pagination="true"
		data-toolbar="#toolbar"
		data-search="true"
		data-url="<?=$link?>"
		data-formatter="LinkFormatterCandidato">	
	<thead>
		<tr>
			<th data-field="num_candidato" data-sortable="true" data-formatter="LinkFormatterCandidato">Número</th>
			<th data-field="_data_inscricao" >Data Inscrição</th>
			<th data-field="nome_guerra">Nome Guerra</th>
      <th data-field="nucleo">Núcleo</th>
      <th data-field="_status">Status</th>
      <th data-field="_data_convocacao">Data Convocação</th>
		</tr>
	</thead>
</table>
<?php } ?>