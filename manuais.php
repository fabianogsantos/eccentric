<?php
	$sql = "select cod_aeronave,nome
			from aeronave
			where status = 'a'
			order by 2";
	$res = $con->query($sql);
	echo "<h3 class='page-header'>Manuais de voos de nossas aeronaves</h3><br />";
	echo "<p>Escolha abaixo o manual da aeronave que você deseja consultar.</p>";	
	while ($row = $res->fetch_assoc()){
		echo "<a href=\"index.php?pagina=manual&aeronave=".$row['cod_aeronave']."\">".$row['nome']."</a><br />";	
	}
?>
