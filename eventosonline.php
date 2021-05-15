<h3>Eventos online já realizados</h3>
<?php
	$sql = "select * from evento";
	$res = $con->query($sql);
		
	while ($row = $res->fetch_assoc()){
		echo "<p><img src=\"".$dir_imagem."/eventos/".$row['imagem']."\" width=\"480\" alt=\"".$row['des_evento']."\"></p>";	
	}
?>
