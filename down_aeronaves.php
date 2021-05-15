<?php
	if(!isset($_SESSION["callsign"])){
		$sql = "select * from aeronave where cod_posto=1 and status='a'";
		$res = $con->query($sql);
		echo "<div class=\"row\">
			<div class=\"col-md-12\">
				<h1 class=\"page-header\">Download de aeronaves <small>Aeronaves disponíveis para o início na companhia</small></h1>
			</div>
		</div>";

		echo "<div class=\"row\">";
		while($row=$res->fetch_assoc()){
			echo "<div class=\"col-md-3\">
			<class=\"thumbnail\" href=\"".$dir_arquivo_aeronaves.$row['nome_arq']."\">
						<img src=\"".$dir_imagem_aeronaves.$row['imagem_1']."\" alt=\"".$row["nome"]."\">
						<div class=\"caption\">
						<p>".$row["nome"]." - Versão ".$row["versao"]."
						<br><a href=\"".$dir_arquivo_aeronaves.$row['nome_arq']."\"><span class=\"label label-primary\">FS9</span></a>";
			if (!empty($row['nome_arq_fsx']))
				echo "&nbsp;<a href=\"".$dir_arquivo_aeronaves.$row['nome_arq_fsx']."\"><span class=\"label label-warning\">FSX</span></a>";
			echo "</p></div></div>";
		}
	}
	else{
		$callsign = $_SESSION["callsign"];

		$sql = "select * from piloto where callsign = $callsign";
		$res = $con->query($sql);
		$row = $res->fetch_assoc();

		$cod_posto = $row["cod_posto"];

		$sql = "select * from aeronave where cod_posto <= $cod_posto order by nome";
		$res = $con->query($sql);
		$num = $res->num_rows;
		?>
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">Download de aeronaves <small>Aeronaves disponíveis para seu posto</small></h1>
			</div>
		</div>

		<?php

		if ($num>0){
			while($row=$res->fetch_assoc()){
				echo "<div class=\"col-md-3\">
				<class=\"thumbnail\" href=\"".$dir_arquivo_aeronaves.$row['nome_arq']."\">
	        		<img src=\"".$dir_imagem_aeronaves.$row["imagem_1"]."\" alt=\"".$row['nome']."\">
	        		<div class=\"caption\">
	        		<p>".$row["nome"]." - Versão ".$row["versao"]."
							<br><a href=\"".$dir_arquivo_aeronaves.$row['nome_arq']."\"><span class=\"label label-primary\">FS9</span></a>";
				if (!empty($row['nome_arq_fsx']))
					echo "&nbsp;<a href=\"".$dir_arquivo_aeronaves.$row['nome_arq_fsx']."\"><span class=\"label label-warning\">FSX</span></a>";
				echo "</p></div></div>";
			}
		}
	}
?>
</div>