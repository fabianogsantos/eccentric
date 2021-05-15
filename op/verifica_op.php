<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$icaos = $_POST['icaos'];
	$aeronave = $_POST['aeronave'];
	$callsign = $_SESSION['callsign'];
	$erro = TRUE;
	$numIcaos = '';
	$motivo = '';

	//verifica se tem op
	$sqlOP = "select * from op where status = 'a' and callsign=$callsign";
	$resOP = $con->query($sqlOP);
	$temOP = $resOP->num_rows;

	if ($temOP > 0) {
		$motivo = "Você já tem uma OP solicitada. Termine a atual";
		$erroOP = TRUE;
	} else {
		$erroOP = FALSE;
	}

	if ($aeronave == '-1') {
		$erroAeronave = TRUE;
		$nomeAeronave = "?";
		$motivo = "Você não escolheu a aeronave. Volte e corrija.";
	} else {
		$erroAeronave = FALSE;
		$sql = "select * from aeronave where cod_aeronave = $aeronave";
		$res = $con->query($sql);
		$nomeAeronave = $res->fetch_assoc();
		$nomeAeronave = $nomeAeronave['nome'];
	}

	//verifica se tem caracteres não suportados
	if (strstr($icaos, ',')) {
		$erro = TRUE;
		$motivo = "Você digitou alguma VÍRGULA nos ICAOS. Volte e preste atenção no exemplo!<br>";
		$numIcaos = "Você errou na digitação dos ICAOS";
	} else {
		if (strstr($icaos, ' ')) {
			$erro = TRUE;
			$motivo = $motivo . "Você digitou algum ESPAÇO nos ICAOS. Volte e preste atenção no exemplo!<br>";
			$numIcaos = "Você errou na digitação dos ICAOS";
		} else {
			$erro = FALSE;
			$icaos = explode('-', $_POST['icaos']);
			$cidades = array();

			foreach ($icaos as $key) {
				$cidade = getCidade($key, $con);
				if (substr($cidade, 0, 4) == 'ERRO') {
					$verifica2 = FALSE;
				} else {
					$verifica2 = TRUE;
				}
				array_push($cidades, $cidade);
			}
			$numIcaos = count($icaos);

			if ($numIcaos > 25) {
				$erro = FALSE;
				$motivo = $motivo . "Segundo o Regulamento Geral, o n&uacute;mero m&aacute;ximo de pernas em uma OP &eacute; 50. Voc&ecirc; ultrapassou este limite. Corrija antes de prosseguir.<br>";
			} else
					if ($numIcaos == 1) {
				$erro = TRUE;
				$motivo = $motivo . "Voce só digitou 1 ICAO. No mínimo são 2. Volte e corrija<br>";
			} else
						if ($numIcaos == 0) {
				$erro = TRUE;
				$motivo = $motivo . "Voce não digitou ICAO algum. No mínimo são 2. Volte e corrija<br>";
			} else
				$erro = FALSE;
		}
	}
}
?>
<script>
	function voltar() {
		window.history.back();
	}
</script>
<h2 class="page-header">Solicitação de OP <small>Confira atentamente os dados</small></h2>
<?php
if (!$erro && !$erroAeronave && !$erroOP) {
	echo "<div class=\"alert alert-success\">
 			<strong>Ok!</strong> Sua solicitação está correta.
 			</div>";
} else {
	echo "<div class=\"alert alert-danger\">
			<strong>Erro:</strong> Sua solicitação contém algum tipo de erro. Volte e corrija.
			</div>";
	echo "<div class=\"alert alert-warning\">
				<strong>Erro:</strong> " . $motivo . "</div>";
}
?>
<p><strong>Aeronave escolhida:</strong> <?php echo $nomeAeronave ?></p>
<p><strong>Pernas:</strong>
	<?php
	$pernas = $numIcaos - 1;
	if ($pernas == -1)
		echo "Erro na digitação dos ICAOS";
	else
		echo $pernas;
	?></p>
<div class="row">
	<div class="col-md-6">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>Icao</th>
					<th>Cidade</th>
				</tr>
			</thead>
			<tbody>
				<?php
				for ($i = 0; $i < $numIcaos; $i++) {
					echo "<tr><td>" . strtoupper($icaos[$i]) . "</td><td>" . $cidades[$i] . "</td></tr>";
				}
				?>
			</tbody>
		</table>
		<?php
		if (!$erro && !$erroAeronave && !$erroOP) {
			echo "<a href=\"" . $_SERVER['PHP_SELF'] . '?pagina=op/gravaOp' . "\" class=\"btn btn-primary\" >Solicitar a OP</a>";
			$_SESSION['icaos'] = $icaos;
			$_SESSION['aeronave'] = $aeronave;
			$_SESSION['callsign'] = $callsign;
		}
		?>
		<button type="button" class="btn btn-danger" onclick="voltar()">Voltar</button>
	</div>
</div>