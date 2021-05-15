<?php 
	$callsign  = $_SESSION['callsign'];

	$sql = "select * from piloto where callsign = $callsign";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	
	$cod_posto = $row["cod_posto"];
	
	$sql = "select * from aeronave where cod_posto <= $cod_posto order by nome";
	$res = $con->query($sql);

 ?>

 <div class="row">
 	<h2>Solicitação de OP</h2>
 	<hr>
	 <div class="col-md-6">
	 	<h3>Instruções <small>Leia atentamente</small></h3>
	 	<ol>
	 		<li>Escolha a aeronave</li>
	 		<li>Digite os ICAOs da sua OP</li>
	 	</ol>
	 	<p>Digite cada ICAO <strong>separado por um TRAÇO E SEM ESPAÇO em branco.</strong>.</p>
	 	<p>Maiúsculas e minúsculas são aceitas.</p>
	 	<p><strong> SIGA O Exemplo: </strong><code>SBRP<strong>-</strong>SBCF<strong>-</strong>SBAQ<strong>-</strong>SBGP</code></p>
	 </div>
	 <div class="col-md-6">
		<form action="<?php echo $_SERVER['PHP_SELF'].'?pagina=op/verifica_op'; ?>" method="POST" role="form">
			<div class="form-group">
				<label for="aeronave">Aeronave</label>
				<select name="aeronave" id="inputAeronave" class="form-control" required="required">
					<option value="-1">Escolha</option>
					<?php
						while ($row = $res->fetch_assoc()){
							echo "<option value=\"".$row['cod_aeronave']."\">".$row['nome']."</option>";
						}
					?>
				</select>
			</div>

			<div class="form-group">
				<label for="icaos">Icaos</label>
				<textarea name="icaos" class="form-control"></textarea>
			</div>

			<button type="submit" class="btn btn-primary">Prosseguir</button>
			<button type="reset" class="btn btn-danger">Limpar</button>
		</form>
	 </div>
	</div>

