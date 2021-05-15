<style type="text/css">
table#alter td {background: #CCFF99}
table#alter tr.dif td {background:#EEEEEE;}
table#alter th {
	background:#236f65;
	color:#F5F5F5;
	}
</style>
<?
  	echo "<h3>Voos Humanitários</strong></h3>";
	
	echo "<br /><p align='justify'>Os Voos Humanitários são realizados por pilotos graduados no posto mínimo de Primeiro Oficial Internacional. A distância em milhas náuticas entre a origem e o destino foi estabelecida por uma linha reta, e a duração do voo leva em consideração a velocidade cruzeiro do MD-11 \"Friend of Winds\" (508 nós), aeronave específica para a realização desta categoria de voo. Maiores detalhes no Catálogo de Rotas.</p><br />";

  	echo "<TABLE border='1' align='center' bordercolor='#003333' id='alter'>";
	echo "<tr><th align='center' colspan='2'>&nbsp;Número Voo&nbsp;</th>
	          <th align='center' colspan='2'>&nbsp;ICAO orig/dest&nbsp;</th>
			  <th align='center' rowspan='2'>&nbsp;Duração&nbsp;</th>
			  <th align='center' rowspan='2'>&nbsp;Distancia&nbsp;</th>			  
			  <th align='center' colspan='2'>&nbsp;Cidade de&nbsp;</th></tr>
			  <tr>
			  <th align='center'>&nbsp;Ida&nbsp;</th>
			  <th align='center'>&nbsp;Volta&nbsp;</th>	
			  <th align='center' colspan='2'>&nbsp;(Inverso na volta)&nbsp;</th>	 		  		  
			  <th align='center'>&nbsp;Origem&nbsp;</th>			  
			  <th align='center'>&nbsp;Destino&nbsp;</th>			  
	     </tr>";
	
	$sql_rotas = "select n_seq,n_ida,n_volta,tempo,distancia,icao_origem,icao_destino,cidade_origem,cidade_destino from rotas where  tipo like 'vh%' order by n_ida";
	$res_rotas = mysql_query($sql_rotas);
	$prim = 1;
	$cor="";
	while ($row=mysql_fetch_assoc($res_rotas)){
		$seqlida = $row['n_seq'];
		
		if ($prim == 1){
			$prim =0;
		}
		else{
			if ($seqlida<>$seq){
				if ($cor == "class='dif'")
					$cor = "";
				else
					$cor = "class='dif'";
			};
		}				

		echo "<tr ".$cor."><td align='center'>".$row['n_ida']."</td>
		          <td align='center'>".$row['n_volta']."</td>
				  <td align='center'>".$row['icao_origem']."</td>
				  <td align='center'>".$row['icao_destino']."</td>
				  <td align='center'>".$row['tempo']."</td>
				  <td align='center'>".$row['distancia']."</td>
				  <td align='center'>".utf8_encode($row['cidade_origem'])."</td>
				  <td align='center'>".utf8_encode($row['cidade_destino'])."</td></tr>";
	}				  
	echo "</table><br />";    
?>