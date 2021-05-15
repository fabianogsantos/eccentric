<?php

	$sql = "select * from estatisticas";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();

?>
<div class="page-header">
	<h1>Estatísticas<small> Ainda em desenvolvimento</small></h1>
</div>
<form name="frm_dadosgerais" method="post" action="index.php?pagina=estatisticas/altera">
	<div class="form-group">
		<label for="hr_antes">Horas voadas por pilotos desligados (antes de 10/08/06): </label>
		<input class="form-control" name="hr_antes" type="text"  value="<?=$row['horas_voadas_antes1008'];?>">
	</div>
	<div class="form-group">
		<label for="hr_apos">Horas voadas por pilotos desligados (após 10/08/06):</label>
		<input class="form-control" name="hr_apos" type="text" value="<?=$row['horas_voadas_apos1008'];?>">
	</div>
	<div class="form-group">
		<label for="dif_vf">Diferença de vôos fretados nas estatísticas:</label>
		<input class="form-control" name="dif_vf" type="text" value="<?=$row['dif_vf'];?>">
	</div>
	<div class="form-group">
		<label for="dif_vh">Diferença de vôos humanitários nas estatísticas:</label>
		<input class="form-control" name="dif_vh" type="text" value="<?=$row['dif_vh'];?>">
	</div>
	<div class="form-group">
		<label for="num_rotas">Número Total de Rotas da Companhia</label>
		<input class="form-control" name="num_rotas" type="text" value="<?=$row['num_rotas'];?>">
	</div>
	<div class="form-group">
		<label for="num_rotas_domesticas">Número de Rotas Domésticas (Passageiros)</label>
		<input class="form-control" name="num_rotas_domesticas" type="text" value="<?=$row['num_rotas_domesticas'];?>">
	</div>
	<div class="form-group">
		<label for="num_rotas_int">Número de Rotas Internacionais (Passageiros)</label>
		<input class="form-control" name="num_rotas_int" type="text" value="<?=$row['num_rotas_int'];?>">
	</div>
	<div class="form-group">
		<label for="num_op_carga">Número de Operações de Carga</label>
		<input class="form-control" name="num_op_carga" type="text" value="<?=$row['num_op_carga'];?>">
	</div>
	<div class="form-group">
		<label for="num_op_carga">Número de Operações de Carga</label>
		<input class="form-control" name="num_op_carga" type="text" value="<?=$row['num_op_carga'];?>">
	</div>
	<div class="form-group">
		<label for="num_destinos">Número de Destinos no Brasil e no Mundo</label>
		<input class="form-control" name="num_destinos" type="text" value="<?=$row['num_destinos'];?>">
	</div>
	<div class="form-group">
		<label for="num_paises">Países/Territórios Servidos pela Companhia</label>
		<input class="form-control" name="num_paises" type="text" value="<?=$row['num_paises'];?>">
	</div>
	<div class="form-group">
		<label for="num_voos_multiplayer">Vôos MultiPlayer</label>
		<input class="form-control" name="num_voos_multiplayer" type="text" value="<?=$row['num_voos_multiplayer'];?>">
	</div>
	<div class="form-group">
		<label for="num_voos_disponiveis">Número de Vôos Disponíveis na Eccentric Travels</label>
		<input class="form-control" name="num_voos_disponiveis" type="text" value="<?=$row['num_voos_disponiveis'];?>">
	</div>
	<div class="form-group">
		<label for="qtd_op">Ordens de Operação (Concedidas)</label>
		<input class="form-control" name="qtd_op" type="text" value="<?=$row['qtd_op'];?>">
	</div>
	<input type="submit" name="Submit" value="Ok" class="btn btn-primary">
</form>
