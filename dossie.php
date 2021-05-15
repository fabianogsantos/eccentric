<?php
	$piloto = $_GET["piloto_callsign"];

	function data_instrutor($data){
		$a = explode("-",$data);
		$b = $a[1]."/".$a[0];
		return ($b);
	}


	$sql = "select * from piloto where callsign = $piloto";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	$cod_posto = $row["cod_posto"];
	$nomeGuerra = $row["nome_guerra"];
	$data_ingresso = ansi2br($row["data_ingresso"]);
	$nucleo = $row["nucleo"];
	$cidade = utf8_encode($row["cidade"]);
	$uf = $row["uf"];
	$imagem = $row["imagem"];

	$sql = "select nome_nucleo from nucleo where sigla_nucleo = '$nucleo'";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	$nucleo = $row["nome_nucleo"];

	$sql = "select * from dossie_piloto where callsign = $piloto";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();

	//$qtd_estrelas = $row['qtd_Estrelas'];
	$qtd_voos = $row["qtd_Voos"];
	$qtd_estrelas_ouro = $row["qtd_estrela_ouro"];
	$qtd_diplomas = $row["qtd_diploma_estrela_ouro"];
	$qtd_op = $row["qtd_op"];
	$qtd_voos_ae_desat = $row["qtd_voos_ae_desat"];
	$ultima_alt_dossie = $row["ultima_alt_dossie"];
	$qtdvoosoffline = $row['qtdvoosoffline'];
	$qtdvoosivao = $row['qtdvoosivao'];
	$qtdvoosvatsim = $row['qtdvoosvatsim'];
	$qtdvoosoutras = $row['qtdvoosoutras'];
	$tempovoooffline = $row['tempovoooffline'];
	$tempovoovatsim=$row['tempovoovatsim'];
	$tempovooivao = $row['tempovooivao'];
	$tempovoooutras = $row['tempovoooutras'];
	$tempovoo_antes_ago2006 = $row['tempovoo_antes_ago2006'];
	$qtdvoosonline = $qtdvoosivao+$qtdvoosvatsim+$qtdvoosoutras;
	$qtd_horas_voo = $row['qtd_horas_voo'];
	$qtd_estrelas = floor($qtd_horas_voo/100);
	$dataUltimoVoo = $row["data_ult_voo"];
	$ultimosVoos = $row["ultimos_voos"];

	$sql = "select * from piloto_vf where callsign = $piloto";
	$res = $con->query($sql);
	$qtd_ch = $res->num_rows;

	$sql = "select * from piloto_vh where callsign = $piloto";
	$res = $con->query($sql);
	$qtd_vh = $res->num_rows;

	$sql = "select * from piloto_me where callsign = $piloto";
	$res = $con->query($sql);
	$qtd_me = $res->num_rows;

	$sql = "select nome_posto from posto where cod_posto = $cod_posto";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();

	$tem_onu = 0;

	$nome_posto = $row["nome_posto"];
    echo "<h1>".$nome_posto." - Cmte. ".$nomeGuerra."</h1>";
?>
<div class="row">
	<div class="col-md-10">
		<TABLE class='table table-condensed'>
			<tr>
		    <TD><strong>Nome de Guerra: </strong></TD>
		    <TD> <?php echo $nomeGuerra ?> </TD>
		  </TR>

		  <TR>
		    <TD><strong>C&oacute;digo P&uacute;blico/Callsign: </strong></TD>
		    <TD>ETR-<?php echo completazeros($piloto) ?></TD>
		  </TR>

		  <TR>
		    <TD><strong>Data de Ingresso: </strong></TD>
		    <TD><?php echo $data_ingresso ?></TD>
		  </TR>

		  <TR>
		    <TD><strong>N&uacute;cleo de Opera&ccedil;&otilde;es: </strong></TD>
		    <TD><?php echo $nucleo ?></TD>
		  </TR>

		  <TR><TD><strong>Resid&ecirc;ncia Atual: </strong></TD>
		  <TD><?php echo $cidade." - ".$uf ?></TD>
		  </TR>

		  <TR>
		    <TD><strong>Aeronave Prim&aacute;ria: </strong></TD>
			<?php
			if ($cod_posto>'7'){
				echo "<TD>Todos os modelos</TD></TR>";
			}
			else {
				if ($nucleo=='Belo Horizonte'){
					$sql_a = "select ae.nome, ae.nome_guerra from aeronave ae, piloto p where p.callsign = $piloto and flg_aeronave_primaria = '1' and p.cod_posto = ae.cod_posto and tipo_aeronave = 'c'";
					$res_a = $con->query($sql_a);
					$row_a = $res_a->fetch_assoc();
					$aeronave_primaria = $row_a["nome"];
					echo "<TD>".$aeronave_primaria."</TD></TR>";
				}
				else {
					$sql_a = "select ae.nome, ae.nome_guerra from aeronave ae, piloto p where p.callsign = $piloto and flg_aeronave_primaria = '1' and p.cod_posto = ae.cod_posto and tipo_aeronave in ('p','t')";
					$res_a = $con->query($sql_a);
					$row_a = $res_a->fetch_assoc();
					$aeronave_primaria = $row_a["nome"];
					echo "<TD>".$aeronave_primaria."</TD></TR>";
				}
			}

			$sql = "select des_cargo from cargo where cod_cargo in (select cod_cargo from piloto_cargo where callsign = $piloto)";
			$res = $con->query($sql);
			$nlin = $res->num_rows;
			$i = 1;

			if ($nlin>0){
				echo "<TR><TD><strong>Cargos Atuais: </strong></TD>";
				echo "<TD>";
				while ($row=$res->fetch_assoc()){
					echo "# ".$row["des_cargo"]."<br>";
				}
				echo "</TD></TR>";
			}

			?>

			<TR><TD><strong>&Uacute;ltima altera&ccedil;&atilde;o no dossi&ecirc;: </strong></TD><TD><?php echo ansi2br($ultima_alt_dossie); ?></TD></TR>
			<tr><td><strong>&Uacute;ltimo voo:</strong></td><td><?php echo ansi2br($dataUltimoVoo); ?></TD></TR>
			<tr><td><strong>N&uacute;mero do &Uacute;ltimo voo:</strong></td><td><?php echo $ultimosVoos;?></TD></TR>
		</TABLE>
	</div>

	<div class="col-md-2 hidden-xs">
		<img src="<?php echo $dir_imagem_pilotos.$imagem;?>" class="img-responsive img-thumbnail ">
	</div>
</div>
	
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
  			<div class="panel-heading">Promo&ccedil;&otilde;es</div>
  			<div class="panel-body">
				<TABLE>
				<?php
					$sql = "SELECT p.des_promocao, pp.data_promocao, p.imagem
					        FROM promocao p, piloto_promocao pp
							WHERE pp.callsign = $piloto
							and pp.cod_promocao = p.cod_promocao
							and pp.data_promocao <> '0000-00-00'";
					$res = $con->query($sql);
					$numlin = $res->num_rows;

					if ($numlin > 0){
						while($row = $res->fetch_assoc()){
							echo "<TR><TD><IMG src=\"".$dir_imagem_posto.$row["imagem"]."\"></TD><TD>".$row["des_promocao"]." em ".ansi2br($row["data_promocao"])."</TD></TR>";
						}
					}
				?>
				</TABLE>
  			</div>
		</div>
	</div>

	<?php
		$sql = "select c.imagem,c.des_certificado
				from certificado c, piloto_certificado pc, piloto p
				where pc.callsign=p.callsign
				and c.cod_certificado = pc.cod_certificado
				and p.callsign = $piloto";
		$res = $con->query($sql);
		$num = $res->num_rows;

		if ($num>0){
	?>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Condecora&ccedil;&otilde;es</div>
			  	<div class="panel-body">
			  		<table>
			  			<?php
							while ($row = $res->fetch_assoc()){
								echo "<TR><TD><IMG src=\"".$dir_imagem_certificados.$row["imagem"]."\" with='100'>&nbsp".utf8_encode($row['des_certificado'])."</TD></TR>";
							}?>
					</table>
				</div>
			</div>
		</div>
	<?php
		}
	?>
</div>


<?php
	$sql = "select p.cod_pais,p.nome,p.imagem
	        from pais p, piloto_pais pp
			where p.cod_pais = pp.cod_pais
			and pp.callsign = $piloto
			order by nome";
	$res = $con->query($sql);
	$numlin = $res->num_rows;

	if ($numlin>0){
		echo "<h2 class=\"page-header\">Eccentric Passport</h2><TABLE>";
		$i = 0;
		echo "<tr>";
		while ($row = $res->fetch_assoc()){
			if ($row['cod_pais']==391){
				$tem_onu = 1;
				$imagem_onu = $row['imagem'];
				continue;
			}
			if ($i<18){
			    echo "<IMG src=\"".$row["imagem"]."\" width='60' height='28' alt=\"".$row["nome"]."\" title=\"".$row["nome"]."\">&nbsp;";
			    $i++;
			}
			else {
			    $i=1;
			    echo "<br>";
			    echo "<IMG src=\"".$row["imagem"]."\" width='60' height='28' alt=\"".$row["nome"]."\" title=\"".$row["nome"]."\">&nbsp;";
			}
		}
		echo "</tr></TABLE>";
		if ($tem_onu){
			echo "<table><tr>";
			echo "<TD><IMG src=\"".$imagem_onu."\" alt=\"Esta bandeira concede ao piloto que pousou em todos os países do mundo o digno título de Representante da Eccentric junto a ONU\" title=\"Esta bandeira concede ao piloto que pousou em todos os países do mundo o digno título de Representante da Eccentric junto a ONU\"></TD></tr></table>";
		}
		echo "<br/>";
	}
?>

<?php
	$sql = "select imagem from vf, piloto_vf pf where pf.cod_vf = vf.cod_vf and pf.callsign = $piloto";
	$res = $con->query($sql);
	$numlin = $res->num_rows;
	$i = 0;
	if ($numlin>0) {
		echo "<h2 class=\"page-header\">Voos Fretados</h2><TABLE><tr>";
		while ($row = $res->fetch_assoc()){
		    if ($i<5){
			    echo "<IMG src=\"".$dir_imagem_vf.$row["imagem"]."\" width='200' height='130'/>&nbsp;";
			    $i++;
		    }
		    else {
		        $i=1;
			    echo "<br>";
			    echo "<IMG src=\"".$dir_imagem_vf.$row["imagem"]."\" width='200' height='130'/>&nbsp;";
		    }
		}
		echo "</tr>";
	}
?>
</TABLE><br>

<?php
	$sql = "select imagem from vh, piloto_vh ph where ph.cod_vh = vh.cod_vh and ph.callsign = $piloto";
	$res = $con->query($sql);
	$numlin = $res->num_rows;
	$i = 0;

	if ($numlin>0){
		echo "<h2 class=\"page-header\">Voos Humanit&aacute;rios</h2><TABLE align='center'><tr>";
		while ($row = $res->fetch_assoc()){
		    if ($i<5){
			    echo "<IMG src=\"".$dir_imagem_vh.$row["imagem"]."\" width='200' height='130'>&nbsp;";
			    $i++;
		    }
		    else {
		        $i=1;
			    echo "<br>";
			    echo "<IMG src=\"".$dir_imagem_vh.$row["imagem"]."\" width='200' height='130'>&nbsp;";
		    }
		}
		echo "</tr>";
	}
?>
</TABLE>

<?php
	$sql = "select imagem from me, piloto_me pm where pm.cod_me = me.cod and pm.callsign = $piloto";
	$res = $con->query($sql);
	$numlin = $res->num_rows;
	if ($numlin>0){
		echo "
		<div class='row'>
			<div class='col-lg-12'>
				<h2 class='page-header'>Missões Especiais</h2>
			</div>";
		while ($row = $res->fetch_assoc()){
			echo "<div class='col-md-6'>";
			echo "<img src=\"".$dir_imagem_me.$row["imagem"]."\">";
			echo "<div class='caption'>&nbsp;</div>";
			echo "</div>";
		}
		echo "</div>";
	}
?>

<?php
	$sql = "SELECT a.nome,b.cod_aeronave,b.qtd_voos
			FROM  piloto_aeronave b, aeronave a
			WHERE callsign = $piloto
			AND b.cod_aeronave IN (
				SELECT cod_aeronave
				FROM aeronave
				WHERE tipo_aeronave = 'p'
			)
			AND a.cod_aeronave = b.cod_aeronave";

	$res = $con->query($sql);
	$num = $res->num_rows;
	?>

	<h2 class="page-header">Voos</h2>
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">Transporte de Passageiros</div>
				<div class="panel-body">
					<table class='table table-condensed'>
					<?php
					if ($num>0){
						while ($row=$res->fetch_assoc()){  //gera a lista de todas as aeronaves, por tipo
							echo "<tr><TD>".$row['nome']."</TD>";
							echo "<TD><span class='badge'>".$row['qtd_voos']."</span></TD></TR>";
						}
					}
					?>
					</table>
				</div>
			</div>
		</div>

	<?php
	$sql = "SELECT a.nome,b.cod_aeronave,b.qtd_voos
			FROM  piloto_aeronave b, aeronave a
			WHERE callsign = $piloto
			AND b.cod_aeronave IN (
				SELECT cod_aeronave
				FROM aeronave
				WHERE tipo_aeronave = 'c'
			)
			AND a.cod_aeronave = b.cod_aeronave";

	$res = $con->query($sql);
	$num = $res->num_rows;

	if ($num>0){
	?>
		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">Transporte de Carga</div>
				<div class="panel-body">
					<table class='table table-condensed'>
					<?php
						while ($row=$res->fetch_assoc()){  //gera a lista de todas as aeronaves, por tipo
							echo "<tr><TD>".$row['nome']."</TD>";
							echo "<TD align='center'><span class='badge'>".$row['qtd_voos']."</span></TD></TR>";
						}
					?>
					</table>
				</div>
			</div>
		</div>
	<?php
	}
	?>



	<?php
	$sql = "SELECT a.nome,b.cod_aeronave,b.qtd_voos
			FROM  piloto_aeronave b, aeronave a
			WHERE callsign = $piloto
			AND b.cod_aeronave IN (
				SELECT cod_aeronave
				FROM aeronave
				WHERE tipo_aeronave = 't'
			)
			AND a.cod_aeronave = b.cod_aeronave";

	$res = $con->query($sql);
	$num = $res->num_rows;

	if ($num>0){
	?>
		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">T&aacute;xi A&eacute;reo</div>
				<div class="panel-body">
					<table class='table table-condensed'>
					<?php
						while ($row=$res->fetch_assoc()){  //gera a lista de todas as aeronaves, por tipo
							echo "<tr><TD>".$row['nome']."</TD>";
							echo "<TD align='center'><span class='badge'>".$row['qtd_voos']."</span></TD></TR>";
						}
					?>
					</table>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	</div>


	<h2 class="page-header">Informações Gerais</h2>
	<div class="row">
		<div class="col-md-6">
			<div class='panel panel-primary'>
			<div class='panel-heading'>Estatísticas</div>
				<div class='panel-body'>
					<table class='table table-condensed'>
					<?php
						$tempovooonline = soma_horas($tempovooivao,$tempovoovatsim);
						$tempovooonline = soma_horas($tempovooonline,$tempovoooutras);
					?>
					  <TR>
					    <TD width="300">Total Geral de Horas de Voo&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$qtd_horas_voo."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD width="300">Horas de Voo Online na Ivao *&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$tempovooivao."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD width="300">Horas de Voo Online na Vatsim *&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$tempovoovatsim."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD width="300">Horas de Voo Online em Outras Redes&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$tempovoooutras."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD width="300">Total de Horas de Voo Online&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$tempovooonline."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD width="300">Horas de Voo Offline *&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$tempovoooffline."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD width="300">Horas de Voo Anteriores a Agosto/06&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$tempovoo_antes_ago2006."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD>Total Geral de Voos&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$qtd_voos."</span></TD></TR>"; ?>
					    </TR>
					 <TR>
					    <TD>Voos offline *&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$qtdvoosoffline."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD>Voos Online na Ivao *&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$qtdvoosivao."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD>Voos Online na Vatsim *&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$qtdvoosvatsim."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD>Voos Online em outras redes&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$qtdvoosoutras."</span></TD></TR>"; ?>
					    </TR>
					  <TR>
					    <TD>Total de Voos Online&nbsp;</TD>
					    <?php echo "<TD><span class='badge'>".$qtdvoosonline."</span></TD></TR>"; ?>
					    </TR>
					 <tr>
					 <td colspan='2'><em>( * = Ap&oacute;s Agosto/2006)</em></td></tr>
				</table>
			</div>
		</div>
		</div>
		<div class="col-md-6">
			<?php
			$outrasInfo = $qtd_voos_ae_desat+$qtd_estrelas+$qtd_estrelas+$qtd_diplomas+$qtd_ch+$qtd_vh+$qtd_me+$qtd_op;

			if ($outrasInfo > 0) {
				echo "<div class='panel panel-primary'>";
				echo "<div class='panel-heading'>Outras Informações</div>";
				echo "<div class='panel-body'>";
				echo "<table class='table table-condensed'>";
		  		if ($qtd_voos_ae_desat)
					echo "<TR><TD width='300'>Quantidade de voos em aeronaves desativadas&nbsp;</TD><TD><span class='badge'>".$qtd_voos_ae_desat."</span></TD></TR>";
				if ($qtd_estrelas > 0)
					echo "<TR><TD width='300'>Estrelas&nbsp;</TD><TD><span class='badge'>".$qtd_estrelas."</span></TD></TR>";
				if ($qtd_estrelas_ouro > 0)
					echo "<TR><TD width='300'>Estrelas de ouro&nbsp;</TD><TD><span class='badge'>".$qtd_estrelas_ouro."</span></TD></TR>";
				if ($qtd_diplomas > 0)
					echo "<TR><TD width='300'>Diplomas de voo online&nbsp;</TD><TD><span class='badge'>".$qtd_diplomas."</span></TD></TR>";
				if ($qtd_ch>0)
					echo "<TR><TD width='300'>Charter Flights</TD><TD><span class='badge'>".$qtd_ch."</span></TD></TR>";
				if ($qtd_vh>0)
					echo "<TR><TD width='300'>Voos Humanitários</TD><TD><span class='badge'>".$qtd_vh."</span></TD></TR>";
				if ($qtd_me>0)
					echo "<TR><TD width='300'>Missões Especiais</TD><TD><span class='badge'>".$qtd_me."</span></TD></TR>";
				if ($qtd_op>0)
					echo "<TR><TD width='300'>Ordens de Operação</TD><TD><span class='badge'>".$qtd_op."</span></TD></TR>";
				echo "</TABLE>";
				echo "</div>";
			}
			?>
		</div>
	</div>

<?php
	$sql = "select a.nome, a.nome_guerra, a.imagem_1, pii.data_qo, pii.tipo_qo
			from piloto p, piloto_qo pii, aeronave a
			where pii.data_qo <> '0000-00-00'
			and p.callsign = pii.callsign
			and pii.cod_aeronave = a.cod_aeronave
			and p.callsign = $piloto
			order by pii.data_qo asc";
	$res = $con->query($sql);
	$num = $res->num_rows;


	if($num>0){
		echo "<div class=\"row\">
			<div class=\"col-lg-12\">
			    <h2 class=\"page-header\">Qualificação Operacional</h2>
			</div>";

			while ($row=$res->fetch_assoc()){
				echo "
				<div class='col-md-3'>
		        	<img src='".$dir_imagem_aeronaves."/".$row["imagem_1"]."'\>
		        	<div class='caption'>";

        				if ($row['tipo_qo']=='i')
        					echo data_instrutor($row['data_qo'])."<br>Instrutor ".$row['nome']."</p>";
        				else
        					echo data_instrutor($row['data_qo'])."<br>Cmte. Mor ".$row['nome']."</p>";
        			echo "</div>
				</div>";
			}
	echo "</div>";
	}
?>

<?php
	$sql = "select e.imagem
			from evento e, piloto_evento pe, piloto p
			where pe.callsign=p.callsign
			and e.cod_evento = pe.cod_evento
			and p.callsign = $piloto";
	$res = $con->query($sql);
	$num = $res->num_rows;

	if ($num>0){
		echo "
		<div class=\"row\">
			<div class=\"col-lg-12\">
			    <h2 class=\"page-header\">Eventos Online</h2>
			</div>";

			while ($row = $res->fetch_assoc()){
				echo "<div class='col-md-6'>";
				echo "<img src='".$dir_imagem_eventos.$row["imagem"]."'/>";
				echo "<div class='caption'>&nbsp;</div>";
				echo "</div>";
			}
			echo "</div>";
	}
?>

<?php
	$sql = "select mp.imagem
			from mp, piloto_mp pmp, piloto p
			where pmp.callsign=p.callsign
			and mp.cod = pmp.cod
			and p.callsign = $piloto";

	$res = $con->query($sql);
	$num = $res->num_rows;

	if ($num>0){
		echo "
		<div class='row'>
			<div class='col-lg-12'>
				<h2 class='page-header'>Voos Multiplayer</h2>
			</div>";

		while ($row = $res->fetch_assoc()){
			echo "<div class='col-md-6'>";
			echo "<img src='".$dir_imagem_mp.$row["imagem"]."'/>";
			echo "<div class='caption'>&nbsp;</div>";
			echo "</div>";
		}
		echo "</div>";
	}
?>

<?php
	$sql = "select tetr.imagem
			from tetr, piloto_tetr, piloto
			where piloto_tetr.callsign=piloto.callsign
			and tetr.cod_tetr = piloto_tetr.cod_tetr
			and piloto.callsign = $piloto";

	$res = $con->query($sql);
	$num = $res->num_rows;

	if ($num>0){
		echo "
		<div class='row'>
			<div class='col-lg-12'>
				<h2 class='page-header'>Tours ETR</h2>
			</div>";

		while ($row = $res->fetch_assoc()){
			echo "<div class='col-md-2'>";
			echo "<img src='".$dir_imagem_tetr.$row["imagem"]."'/>";
			echo "<div class='caption'>&nbsp;</div>";
			echo "</div>";
		}
		echo "</div>";
	}
?>

</div>