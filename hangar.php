<?php
	$sql = "select * from aeronave where status = 'a' order by nome";
	$res = $con->query($sql);
 ?>
<div class="row">
	<div class="col-lg-12">
	    <h1 class="page-header">Nossas aeronaves   <small>Clique nas imagens para baixar o manual</small></h1>
	</div>


	<?php 
		while ($row=$res->fetch_assoc()){
			echo "<div class=\"col-md-3\">
	    			<a class=\"thumbnail\" href=\"index.php?pagina=manual&aeronave=".$row['cod_aeronave']."\">
	        		<img src=\"".$dir_imagem_aeronaves."/".$row['imagem_1']."\" alt=\"".$row["nome"]."\">
	        		<div class=\"caption\">
	        		<p align='center'>".$row["nome"]."</p>
	        		</div>
	        		</a>
				</div>";
		}
	 ?>
</div>