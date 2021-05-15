<?php  
  $p_nucleo = $_GET["nucleo"];

  $sql = "select * from nucleo where sigla_nucleo = '$p_nucleo'";
  $res = $con->query($sql);
  $row = $res->fetch_assoc();
  
?>
<h1 class="page-header">Núcleo <?=$row["nome_nucleo"].' - '.$row["nucleo_tipo"];?> <br><small>Sede: <?=$row["sede_nucleo"];?> </small></h1>
<div class="row">
<div class="col-md-10">
<table class="table table-condensed table-hover">
	<thead>
		<tr>
			<th>Posto</th>
			<th>Piloto</th>
			<th>Total Voos</th>
		    <th>Voos Fretados</th>
		    <th>Voos Humanit.</th>
		    <th>Horas</th>
			<th>Estrelas</th>
			<th>País</th>
		</tr>
	</thead>
	<tbody>
<?php
  
  $sql = "select pos.imagem as imgPosto, p.callsign, p.nome_guerra, dp.qtd_Estrelas,dp.tempovoooffline, dp.tempovoovatsim,dp.tempovooivao, dp.tempovoooutras, dp.tempovoo_antes_ago2006, dp.qtd_Voos, dp.qtd_vf, dp.qtd_vh, pa.imagem
          from posto pos, piloto p, dossie_piloto dp, pais pa
		  where p.callsign = dp.callsign
		  and p.cod_posto = pos.cod_posto
		  and p.cod_pais = pa.cod_pais
  		  and p.nucleo = '$p_nucleo'
		  and p.status = 'a'
		  order by p.callsign";
	$res = $con->query($sql);		  
	while ($row = $res->fetch_assoc()){		
		$tempovoooffline = $row['tempovoooffline'];
		$tempovoovatsim=$row['tempovoovatsim'];
		$tempovooivao = $row['tempovooivao'];
		$tempovoooutras = $row['tempovoooutras'];	
		$tempovoo_antes_ago2006 = $row['tempovoo_antes_ago2006'];
		$qtd_horas_voo = soma_horas($tempovoooffline,$tempovoooutras);
		$qtd_horas_voo = soma_horas($qtd_horas_voo,$tempovoovatsim);
		$qtd_horas_voo = soma_horas($qtd_horas_voo,$tempovooivao);	
		$qtd_horas_voo = soma_horas($qtd_horas_voo,$tempovoo_antes_ago2006);
		
		$numEstrelas = floor($qtd_horas_voo/100);
		
		echo "<TD><IMG src=\"".$dir_imagem_posto.$row["imgPosto"]."\"></TD>
				<TD><A HREF=\"index.php?pagina=dossie&piloto_callsign=".$row["callsign"]."\">" . completazeros($row["callsign"])." - ".strtoupper(utf8_encode($row["nome_guerra"]))."</A></TD>
				<TD>" . $row["qtd_Voos"]."</TD>
				<TD>".$row["qtd_vf"]."</TD>
				<TD>" . $row["qtd_vh"]."</TD>
				<TD>".$qtd_horas_voo."&nbsp;</TD>
				<TD>".$numEstrelas."</TD>
				<TD><IMG src=\"".$row["imagem"]."\" width=\"30\" height=\"20\"></TD></TR>";
	}							
?>

</tbody>
</table>
</div>
</div>