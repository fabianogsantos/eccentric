<?php 

	$sql = "select * from estatisticas";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();

?>
<br><h1 class="pagetitle">Estatísticas</h1>
<div class='column1-unit'>	
<form name="frm_dadosgerais" method="post" action="../index.php?pagina=man_geral">

	<fieldset>
	<legend><strong>Dados gerais</strong></legend>
	  Horas voadas por pilotos desligados (antes de 10/08/06):<br>
	  <?php
			echo "<input name=\"hr_antes\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['horas_voadas_antes1008']."\"><br>";	  		
	  ?> 
	  Horas voadas por pilotos desligados (após 10/08/06):<br>
	  <?php
			echo "<input name=\"hr_apos\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['horas_voadas_apos1008']."\"><br>";	  		
	  ?>   
	    Diferença de vôos fretados nas estatísticas:<br>
	  <?php
			echo "<input name=\"dif_vf\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['dif_vf']."\"><br>";	  		
	  ?>    
	  	Diferença de vôos humanitários nas estatísticas:<br>
	  <?php
			echo "<input name=\"dif_vh\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['dif_vh']."\"><br>";	  		
	  ?>  
	  Número Total de Rotas da Companhia<br>
	  <?php
			echo "<input name=\"num_rotas\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['num_rotas']."\"><br>";	  		
	  ?>  	  
	  Número de Rotas Domésticas (Passageiros)<br>
	  <?php
			echo "<input name=\"num_rotas_domesticas\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['num_rotas_domesticas']."\"><br>";	  		
	  ?>  	  
	  Número de Rotas Internacionais (Passageiros)<br>
	  <?php
			echo "<input name=\"num_rotas_int\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['num_rotas_int']."\"><br>";	  		
	  ?>  	  
	  Número de Operações de Carga<br>
	  <?php
			echo "<input name=\"num_op_carga\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['num_op_carga']."\"><br>";	  		
	  ?>  	  
	  Número de Destinos no Brasil e no Mundo<br>
	  <?php
			echo "<input name=\"num_destinos\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['num_destinos']."\"><br>";	  		
	  ?>  	  
	  Países/Territórios Servidos pela Companhia<br>
	  <?php
			echo "<input name=\"num_paises\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['num_paises']."\"><br>";	  		
	  ?>  	  
	  Vôos MultiPlayer<br>
	  <?php
			echo "<input name=\"num_voos_multiplayer\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['num_voos_multiplayer']."\"><br>";	  		
	  ?>  	  
	  Número de Vôos Disponíveis na Eccentric Travels<br>
	  <?php
			echo "<input name=\"num_voos_disponiveis\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['num_voos_disponiveis']."\"><br>";	  		
	  ?>  	  
	  Ordens de Operação (Concedidas)<br>
	  <?php
			echo "<input name=\"qtd_op\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"".$row['qtd_op']."\"><br>";	  		
	  ?>  	  
    </select><br>		
  <p>
	<input type="submit" name="Submit" value="Ok" class="botao">	
  </p>
  </fieldset>
</form>
</div>