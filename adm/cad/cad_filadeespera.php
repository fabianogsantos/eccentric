<? 
	$num = $_GET["num"];
	$_acao     = $_GET["acao"];
	if ($_acao=='sel' || $_acao =='alt'){
		$sql = "select * from fila_espera where num = $num";
		$res = mysql_query($sql);
		$row = @mysql_fetch_assoc($res);
		$numero = $row["num"];
	}				
?>

<form name="frm_filadeespera" method="post" action="../man_filadeespera.php">
	
	<h2>Cadastro de candidatos a pilotos da ETR</h2>

	<fieldset>
	<legend><strong>Dados</strong></legend>
	  Nome:
      <?
      	if ($_acao=='sel' || $_acao =='alt'){
      		$valor= $row['nome_candidato'];
      	}
		else {
			$valor= "";
		}
		echo "<input name=\"nome\" type=\"text\" size=\"50\" maxlength=\"100\" value='$valor'><br>";
      ?>	    
	  Cidade: 
      <?
      	if ($_acao=='sel' || $_acao =='alt'){
      		$valor= $row['cidade_candidato'];
      	}
		else {
			$valor= "";
		}
		echo "<input name=\"cidade\" type=\"text\" size=\"50\" maxlength=\"50\" value='$valor'><br>";
      ?>	  
	 Estado: 
      <?
	  
	  	$estados = Array("NA","AC","AL","AM","AP","BA","CE","DF","ES","GO","MA","MG","MS","MT","PA","PB","PE","PI","PR","RJ","RN","RO","RR","RS","SC","SE"		  		  ,"SP","TO");
		echo "<select name =\"uf\">";
      	if ($_acao=='sel' || $_acao =='alt'){
			$valor= $row['uf_candidato'];					
			foreach($estados as $val_array){
	      		if ($val_array == $valor){
					echo "<option value =\"".$val_array."\" selected>".$val_array."</option>";
				}	
				else {
					echo "<option value =\"".$val_array."\">".$val_array."</option>";				
				}
			}
      	}
		else {
			foreach($estados as $val_array){
				echo "<option value =\"".$val_array."\">".$val_array."</option>";
			}
		}
		
		echo "</select> Obs: Para pilotos que residem fora do Brasil, selecione NA.";
      ?>	 
	<br>
    Email: 
      <?
      	if ($_acao=='sel' || $_acao =='alt'){
      		$valor= $row['email_candidato'];
      	}
		else {
			$valor= "";
		}
		echo "<input name=\"email\" type=\"text\" size=\"50\" maxlength=\"50\" value=".$valor.">";
      ?>	  
   	<br>N&uacute;cleo: 
    <?
		$sql = "select * from nucleo";
		$res = mysql_query($sql);
		
		echo "<select name=\"nucleo\">"; 
      	if ($_acao=='sel' || $_acao =='alt'){
      		$valor= $row['nucleo'];
			while ($lin = mysql_fetch_array($res)){ 
				$val = $lin["sigla_nucleo"];
				if ($valor == $val){
					echo "<option value=\"".$lin["sigla_nucleo"]."\" selected>".$lin["nome_nucleo"]."</option>";
				}
				else{
					echo "<option value=\"".$lin["sigla_nucleo"]."\">".$lin["nome_nucleo"]."</option>";
				}	
			}
      	}
		else{
			while ($lin = mysql_fetch_array($res)){ 
				echo "<option value=\"".$lin["sigla_nucleo"]."\">".$lin["nome_nucleo"]."</option>";			
			}
		}
		?>  	  		
    </select><br>
	<?
	echo "<input name=\"num\" type=\"hidden\" size=\"2\" maxlength=\"2\" value=\"".$numero."\"><br>";
	?>
  <p>
	<input type="submit" name="Submit" value="Ok">
  </p>
  </fieldset>
</form>
