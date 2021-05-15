<?php
	$cod_aero = $_GET['aeronave'];
	$sql = "select nome,imagem_1 from aeronave where cod_aeronave = $cod_aero";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	
	echo "<div class=\"onemorebox\">
            <img src=\"".$dir_imagem_aeronaves.$row['imagem_1']."\" class=\"floatTL\" alt=\"Image\" />
			<br /><h3>".$row['nome']."</h3>
   </div><br /><br /><br />";

	$sql = "select * from manual where cod_aeronave = $cod_aero";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	
	echo "<br />".utf8_encode($row['txt_manual']);
?>