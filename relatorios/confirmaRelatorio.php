<?php
	if(!isset($_SESSION["callsign"])){
		?><script language="Javascript">
				window.open("index.php?pagina=pagina&pid=10","_parent");
		</script><?php
    	exit;
	}
	//include '../conecta.php';
	$callsign = $_SESSION["callsign"];
	$modo = $_POST['modo'];
	$tipo = $_POST['tipo'];
	$numeroVoo = $_POST['numeroVoo'];
	$icaoOrigem = $_POST['icaoOrigem'];
	$icaoDestino = $_POST['icaoDestino'];
	$tempoVoo = $_POST['tempoVoo'];
	$dataPartida = $_POST['dataPartida'];
	$codAeronave = $_POST['codAeronave'];
	$distancia = $_POST['distancia'];
	$altitude = $_POST['altitude'];
	$combustivel = $_POST['combustivel'];
	$planoVoo = $_POST['planoVoo'];	
	$dataPartida = br2ansi($dataPartida);
	$hoje = br2ansi(Date("d/m/y"));	
	$icaoOrigem = strtoupper($icaoOrigem);
	$icaoDestino = strtoupper($icaoDestino);
	$numeroVoo=strtoupper($numeroVoo);
	$sqlIns = "INSERT INTO relatorios (modo, 
									   tipo, 
									   numero_voo, 
									   icao_origem, 
									   icao_destino, 
									   data_partida, 
									   tempo_voo, 
									   cod_aeronave, 
									   distancia, 
									   altitude, 
									   combustivel, 
									   plano_voo, 
									   callsign,
									   data_envio_relatorio,
									   status) 
							  VALUES ('$modo', 
									  '$tipo', 
									  '$numeroVoo', 
									  '$icaoOrigem', 
									  '$icaoDestino', 
									  '$dataPartida', 
									  '$tempoVoo', 
									  '$codAeronave', 
									  '$distancia', 
									  '$altitude', 
									  '$combustivel', 
									  '$planoVoo', 
									  '$callsign',
									  '$hoje',
									  1)";
  $Result1 = $con->query($sqlIns);
  ?>
	<script language="Javascript">
	<!--
		alert("Dados enviados!");
		window.open("index.php?pagina=relatorios/novo_relatorio","_self");
	//-->
	</script>  
