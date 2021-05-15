<style type="text/css">
table#alter td {background: #CCFF99}
table#alter tr.dif td {background:#EEEEEE;}
table#alter th {
	background:#236f65;
	color:#F5F5F5;
	}
</style>
<?php  
  $p_nucleo = $_GET["nucleo"];

  $sql = "select * from nucleo where sigla_nucleo = '$p_nucleo'";
  $res = mysql_query($sql);
  $row = mysql_fetch_assoc($res);
  
	echo "<h3>Lista de rotas do núcleo ".$row["nome_nucleo"]."</h3>";
	
	echo "<br /><p align='justify'>Uma rota é composta de voos de ida e de volta. Os voos de ida recebem numeração par, e os de volta numeração ímpar. Havendo escalas, a numeração par e numeração ímpar são sequenciais. Quando a linha do voo muda de cor de verde para branco ou vice-versa, significa que terminou uma rota e inicia outra.</p>";
	echo "<br /><p align='justify'>Clique no posto abaixo para ver as rotas disponíveis de cada um:</p><br />";

function mostraDados($nuc,$pos){
  	echo "<br /><p align='center'><strong>Voos Nacionais</strong></p><br />";

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
	
	$sql_rotas = "select n_seq,n_ida,n_volta,tempo,distancia,icao_origem,icao_destino,cidade_origem,cidade_destino from rotas where sigla_nucleo = '$nuc' and cod_posto = $pos and tipo like 'nac%' order by n_seq,n_ida";
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
		$seq = $row['n_seq'];				  
	}				  
	echo "</table>";		
	
  	echo "<br /><p align='center'><strong>Voos Internacionais</strong></p><br />";

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
	
	$sql_rotas = "select n_seq,n_ida,n_volta,tempo,distancia,icao_origem,icao_destino,cidade_origem,cidade_destino from rotas where sigla_nucleo = '$nuc' and cod_posto = $pos and tipo like 'in%' order by n_seq,n_ida";
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
		$seq = $row['n_seq'];				  
	}				  
	echo "</table><br />";		
}
?>

<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<div id="CollapsiblePanel1" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Primeiro Oficial Regional</div>
  <div class="CollapsiblePanelContent">
  	<?php
	mostraDados($p_nucleo,1);
	?>
  </div>
</div>
<div id="CollapsiblePanel2" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Co-Piloto Regional</div>
  <div class="CollapsiblePanelContent">
  	<?php
	mostraDados($p_nucleo,2);
	?>
  </div>
</div>
<div id="CollapsiblePanel3" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Comandante Regional</div>
  <div class="CollapsiblePanelContent">
  	<?php mostraDados($p_nucleo,3); ?>
  </div>
</div>
<div id="CollapsiblePanel4" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Primeiro Oficial Intenacional</div>
  <div class="CollapsiblePanelContent">
  	<?php mostraDados($p_nucleo,4); ?>
  </div>
</div>
<div id="CollapsiblePanel5" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Co-Piloto Internacional</div>
  <div class="CollapsiblePanelContent">
  	<?php mostraDados($p_nucleo,5); ?>
  </div>
</div>
<div id="CollapsiblePanel6" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Comandante Internacional</div>
  <div class="CollapsiblePanelContent">
  	<?php mostraDados($p_nucleo,6); ?>
  </div>
</div>
<div id="CollapsiblePanel7" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Comandante Transcontinental</div>
  <div class="CollapsiblePanelContent">
  	<?php mostraDados($p_nucleo,7); ?>
  </div>
</div>
<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2", {contentIsOpen:false});
var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3", {contentIsOpen:false});
var CollapsiblePanel4 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel4", {contentIsOpen:false});
var CollapsiblePanel5 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel5", {contentIsOpen:false});
var CollapsiblePanel6 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel6", {contentIsOpen:false});
var CollapsiblePanel7 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel7", {contentIsOpen:false});
//-->
</script>
