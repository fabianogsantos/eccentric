<?php		
	include('../configura.php');
	include('../conecta.php');
	
	
	$numTotalPilotos = $numTotalHoras = $horasNucleo = $numTotalVoos = 0;
	$nucleos = array('bh','sp','rf','rj');
	
	foreach ($nucleos as $val){
		$sql = "SELECT d.callsign,p.nome_guerra as nome,d.qtd_horas_voo,d.qtd_Voos,d.tempovoo_antes_ago2006 as desat,p.nucleo
			FROM dossie_piloto d, piloto p
			WHERE d.callsign = p.callsign
			AND p.status='a'
			and p.nucleo='$val'
			order by d.callsign";
		$res = $con->query($sql);
		
		echo "<table><caption>N&uacute;cleo ".strtoupper($val)."</caption>";
		echo "<tr><th>Callsign</th><th>Nome</th><th>Qtd Voos</th><th>Qtd Horas</th></tr>";
		$hora = '00:00';
		$voos = $i = $horasNucleo = 0;
		while ($row = $res->fetch_assoc()){
			$i = $i + 1;
			$hora  = $row['qtd_horas_voo'];
			$voos  = $voos + $row['qtd_Voos'];
			
			echo "<tr><td>".$row['callsign']."</td>
					<td>".utf8_encode($row['nome'])."</td>
					<td>".$row['qtd_Voos']."</td>
					<td>".$hora."</td></tr>";
			$horasNucleo   = soma_horas($horasNucleo,$hora);
		}
		echo"<tfoot><tr><td align='center'><em>".$i."</em></td><td>&nbsp;</td><td><em>".$voos."</em></td><td><em>".$horasNucleo."</em></td></tfoot></table><br>";
		$numTotalHoras   = soma_horas($numTotalHoras,$horasNucleo);
		$numTotalPilotos = $numTotalPilotos+$i;
		$numTotalVoos    = $numTotalVoos + $voos;
	}
	
	echo "<table><tr><td>Pilotos: ".$numTotalPilotos."</td><td>Voos: ".$numTotalVoos."</td><td>Horas: ".$numTotalHoras."</td></tr></table>";
?></table>