<?php	

	$sql = "select * from estatisticas where id=1";
	$res =$con->query($sql);
	$row = $res->fetch_assoc();
	$dif_vf = $row["dif_vf"];
	$dif_vh = $row["dif_vh"];
	$num_rotas = $row["num_rotas"];
	$num_rotas_domesticas = $row["num_rotas_domesticas"];
	$num_rotas_int = $row["num_rotas_int"];
	$num_op_carga = $row["num_op_carga"];
	$num_destinos = $row["num_destinos"];
	$num_paises = $row["num_paises"];
	$num_voos_multiplayer = $row["num_voos_multiplayer"];
	$num_voos_disponiveis = $row["num_voos_disponiveis"];

	$sql="select count(callsign) as qtd from piloto where status='a'";
	$res = $con->query($sql);
	$num_pilotos = $res->fetch_assoc();
	$num_pilotos = $num_pilotos['qtd'];

	$sql="select count(sigla_nucleo) as qtd from nucleo";
	$res = $con->query($sql);
	$num_nucleos = $res->fetch_assoc();
	$num_nucleos = $num_nucleos['qtd'];

	$sql="select count(cod_aeronave) as qtd from aeronave";
	$res = $con->query($sql);
	$num_aeronaves = $res->fetch_assoc();
	$num_aeronaves =$num_aeronaves['qtd'];

	$sql="select count(cod) as qtd from me";
	$res = $con->query($sql);
	$num_me = $res->fetch_assoc();
	$num_me =$num_me['qtd'];	

	$sql="select sum(qtd_vh) as qtd from dossie_piloto,piloto where piloto.callsign = dossie_piloto.callsign and piloto.status='a'";
	$res = $con->query($sql);
	$qtd_vh = $res->fetch_assoc();
	$qtd_vh =$qtd_vh['qtd']+$dif_vh;		

	$sql="select sum(qtd_vf) as qtd from dossie_piloto,piloto where piloto.callsign = dossie_piloto.callsign and piloto.status='a'";
	$res = $con->query($sql);
	$qtd_vf = $res->fetch_assoc();
	$qtd_vf =$qtd_vf['qtd'] +$dif_vf;		
	
	$sql="select count(cod_evento) as qtd from evento";
	$res = $con->query($sql);
	$qtd_evento = $res->fetch_assoc();
	$qtd_evento = $qtd_evento['qtd'];		

	//soma o numero total de horas na Cia.
	$sql="select tempovoooffline,tempovoovatsim,tempovooivao,tempovoooutras,tempovoo_antes_ago2006 from dossie_piloto dp, piloto p where dp.callsign=p.callsign and p.status='a'";
	$res = $con->query($sql);
	$num_total_horas =  "00:00"; 

	$sql = "select count(*)+364 as qtd_op from op";
	$res = $con->query($sql);
	$qtd_op = $res->fetch_assoc();
	$qtd_op =$qtd_op['qtd_op'];


	while ($row = $res->fetch_assoc()){
		$tempo1 = soma_horas($row["tempovoooffline"],$row['tempovoovatsim']);
		$tempo2 = soma_horas($tempo1,$row['tempovooivao']);
		$tempo3 = soma_horas($tempo2,$row['tempovoooutras']);
		$tempo4 = soma_horas($tempo3,$row['tempovoo_antes_ago2006']);
		$num_total_horas = soma_horas($num_total_horas,$tempo4);
	}

	//soma com os dados dos pilotos inativos antes de 10/08/2006
	$sql="select horas_voadas_antes1008,horas_voadas_apos1008 from estatisticas where id=1";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	$horas_antes = $row["horas_voadas_antes1008"];
	$num_total_horas = soma_horas($num_total_horas,$horas_antes);

	$horas_apos = $row["horas_voadas_apos1008"];
	$num_total_horas = soma_horas($num_total_horas,$horas_apos);
?>

<h3>Dados estatísticos</h3>
<div class="row">
	<div class="col-md-8">
		<div class="table-responsive">          
			<table class="table table-hover table-condensed table-striped">
			<tr><td>Início das Operações</td><td>01/Janeiro/2003</td></tr>
			<tr><td>Horas de Voo da Companhia</td>
			<td><?php echo$num_total_horas; ?></td></tr>
			<tr>
			<td>Número de Pilotos</td>
			<td><?php echo$num_pilotos ?></td></tr>
			<tr>
			<td>Núcleos de Operação</td>
			<td><?php echo$num_nucleos ?></td></tr>	
			<tr>
			<td>Modelos de Aeronaves em Operação</td>
			<td><?php echo$num_aeronaves ?></td></tr>
			<tr>
			<td>Número Total de Rotas da Companhia</td>
			<td><?php echo  $num_rotas ?></td></tr>	 
			<tr>
			<td>Número de Rotas Domésticas (Passageiros)</td>
			<td><?php echo  $num_rotas_domesticas ?></td></tr>
			<tr>
			<td>Número de Rotas Internacionais (Passageiros)</td>
			<td><?php echo  $num_rotas_int ?></td></tr>
			<tr>
			<td>Número de Rotas de Carga</td>
			<td><?php echo  $num_op_carga ?></td></tr>
			<tr>
			<td>Número de Destinos no Brasil e no Mundo</td>
			<td><?php echo  $num_destinos ?></td></tr>
			<tr>
			<td>Países/Territórios Servidos pela Companhia</td>
			<td><?php echo  $num_paises ?></td></tr>
			<tr>
			<td>Voos Fretados (Realizados)</td>
			<td><?php echo  $qtd_vf; ?></td></tr>
			<tr>
			<td>Voos Humanitários (Realizados)</td>
			<td><?php echo  $qtd_vh; ?></td></tr>
			<tr>
			<td>Revoadas (Concluídas)</td>
			<td><?php echo  $qtd_evento ?></td></tr>
			<tr>
			<td>Missões Especiais (Concluídas)</td>
			<td><?php echo  $num_me; ?></td></tr>
			<tr>
			<td>Ordens de Operação (Concedidas)</td>
			<td><?php echo  $qtd_op; ?></td></tr>
			<tr>
			<td>Voos MultiPlayer</td>
			<td><?php echo  $num_voos_multiplayer ?></td></tr>	
			<tr>
			<td>Número de Voos Disponíveis na 'Eccentric'</td>
			<td><?php echo  $num_voos_disponiveis ?></td></tr>
			</table>
		</div>
	</div>
</div>