<?php 
	include '../conecta.php';
	$callsign = $_GET['callsign'];
	$sql = "select cod_posto from piloto where callsign=$callsign";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	$posto = $row['cod_posto'];

	if ($posto<7){
		$sql = "SELECT num as numero,icaoorigem as origemIcao, icaodestino as destinoIcao
				FROM voooficial 
				WHERE posto <= $posto
				ORDER BY 1";
		}
	else {
		$sql = "SELECT num as numero,icaoorigem as origemIcao, icaodestino as destinoIcao
				FROM voooficial 
				ORDER BY 1 ";				
	}
	$res = $con->query($sql);

	$saida = '';
	while ($row=$res->fetch_assoc()){
		$saida = $saida."<option value=\"".$row['numero']."\">".$row['numero']." - ".$row['origemIcao']."/".$row['destinoIcao']."</option>";
	}

	$div = "<div class=\"form-group\">
			<label class=\"control-label col-sm-2\" for=\"vooOficial\">Selecione o voo: </label>
			<div class=\"col-sm-4\">
				<select class=\"form-control\" name=\"vooOficial\" id=\"vooOficial\">
					<option value=\"\">Selecione</option>".$saida."
				</select>
			</div>
		</div>";

	echo $div;
 ?>