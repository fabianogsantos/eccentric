<?php
define('SITE_ROOT', realpath(dirname(__FILE__)));

function br2ansi($data)
{ #converte a data no formato dd/mm/aaaa para aaaa-mm-dd
	$a = explode("/", $data);
	krsort($a);
	$b = implode("-", $a);
	return ($b);
}

function ansi2br($data)
{ # converte data de aaaa--mm-dd para dd/mm/aaaa
	$a = explode("-", $data);
	krsort($a);
	$b = implode("/", $a);
	return ($b);
}

function ansi2br2($data)
{ # converte data de aaaa--mm-dd para dd/mm/aaaa
	$a = explode("-", $data);
	krsort($a);
	$ano = $a[0];
	$a[0] = substr($a[0], 2);
	$b = implode("/", $a);
	return ($b);
}


function date_diff2_old($from, $to)
{
	// formato da data dd/mm/yyyy
	list($from_day, $from_month, $from_year) = explode("/", $from);
	list($to_day, $to_month, $to_year) = explode("/", $to);

	$from_date = mktime(0, 0, 0, $from_month, $from_day, $from_year);
	$to_date = mktime(0, 0, 0, $to_month, $to_day, $to_year);

	$days = ($to_date - $from_date) / 86400;

	return ceil($days);
}

function date_diff2($data_inicial, $data_final)
{

	$time_inicial = geraTimestamp($data_inicial);
	$time_final = geraTimestamp($data_final);

	$diferenca = $time_final - $time_inicial;

	// Calcula a diferena de dias
	$dias = (int)floor($diferenca / (60 * 60 * 24));
	return $dias;
}

function geraTimestamp($data)
{
	$partes = explode('/', $data);
	return mktime(0, 0, 0, (int)$partes[1], (int)$partes[0], (int)$partes[2]);
}

function soma_horas($hora, $deltat)
{
	$arr_ret = array();
	$vet_deltat = array();
	$vet_hora = array();

	$vet_hora = explode(':', $hora);
	$vet_deltat = explode(':', $deltat);

	@$som_hora = $vet_hora[0] + $vet_deltat[0];
	@$som_min = $vet_hora[1] + $vet_deltat[1];

	if ($som_min >= 60) {
		$som_hora++;
		$som_min = $som_min - 60;
		if ($som_min == 0) {
			$som_min = "00";
		}
	}
	return $som_hora . ":" . str_pad($som_min, 2, '0', STR_PAD_LEFT);
}

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
	// Caracteres de cada tipo
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';

	// Variáveis internas
	$retorno = '';
	$caracteres = '';

	// Agrupamos todos os caracteres que poderão ser utilizados
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;

	// Calculamos o total de caracteres possíveis
	$len = strlen($caracteres);

	for ($n = 1; $n <= $tamanho; $n++) {
		// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
		$rand = mt_rand(1, $len);
		// Concatenamos um dos caracteres na variável $retorno
		$retorno .= $caracteres[$rand - 1];
	}

	return $retorno;
}

function montadata($timestamp)
{
	$tmp_data = substr($timestamp, 0, 10);
	$tmp_hora = substr($timestamp, 11, 8);
	$tmp_data = ansi2br($tmp_data);
	$data = $tmp_data . " " . $tmp_hora;
	return $data;
}

function completazeros($callsign)
{
	$tmp = strlen($callsign);
	if ($tmp == 1) {
		$ret = str_pad($callsign, 3, "0", STR_PAD_LEFT);
	} else if ($tmp == 2) {
		$ret = str_pad($callsign, 3, "0", STR_PAD_LEFT);
	} else {
		$ret = $callsign;
	}
	return $ret;
}

function ansi2brcompleto($p_data)
{
	$data = ansi2br(substr($p_data, 0, 10));
	$hora = substr($p_data, 11, 8);
	return $data . " " . $hora;
}

function trataStatusPiloto($sta)
{
	switch ($sta) {
		case "a":
			$estado = "Ativo";
			break;
		case "i":
			$estado = "Inativo";
			break;
		case "c":
			$estado = "Candidato";
			break;
	}
	return $estado;
}

function trataVooOnline($status)
{
	switch ($status) {
		case "s":
			$retorno = "Sim";
			break;
		case "n":
			$retorno = "No";
			break;
	}
	return $retorno;
}

function trataModo($m)
{
	switch ($m) {
		case "i":
			$ret = "Ivao";
			break;
		case "o":
			$ret = "Offline";
			break;
		case "v":
			$ret = "Vatsim";
			break;
	}
	return $ret;
}

function trataTipoVoo($tv)
{
	switch ($tv) {
		case "o":
			$ret = "Oficial";
			break;
		case "e":
			$ret = "Extra-Oficial";
			break;
	}
	return $ret;
}

function trataRelatorio($sta)
{
	switch ($sta) {
		case 1:
			$retorno = "Aguardando";
			break;
		case 2:
			$retorno = "Aprovado";
			break;
		case 3:
			$retorno = "Reprovado";
			break;
		case 4:
			$retorno = "Cancelado";
			break;
		case 5:
			$retorno = "Pendente";
			break;
	}
	return $retorno;
}

function trataPlanoVoo($p)
{
	switch ($p) {
		case "fsn":
			$ret = "FS Navigator";
			break;
		case "fs":
			$ret = "Flight Simulator Planner";
			break;
		case "r":
			$ret = "Route Finder";
			break;
		case "c":
			$ret = "Cartas";
			break;
		case "o":
			$ret = "Outros";
			break;
	}
	return $ret;
}

function getAeronave($cod, $con)
{
	$sql = "select nome from aeronave where cod_aeronave = $cod";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();

	$aeronave = $row['nome'];
	return $aeronave;
}

function getIcaos($numVoo, $con)
{
	$sql = "select icaoorigem, icaodestino from voooficial where num = '$numVoo'";
	$res = $con->query($sql);
	$num = $res->num_rows;
	$retorno = array();

	if ($num > 0) {
		$row = $res->fetch_assoc();
		$origem = $row['icaoorigem'];
		$dest = $row['icaodestino'];
		$cidOrigem = getCidade($origem, $con);
		$cidDest = getCidade($dest, $con);
	} else {
		$sql = "select icaoorigem, icaodestino from rotas where num = '$numVoo'";
		$res = $con->query($sql);
		$row = $res->fetch_assoc();
		$origem = $row['icaodestino'];
		$dest = $row['icaoorigem'];
		$cidOrigem = getCidade($origem, $con);
		$cidDest = getCidade($dest, $con);
	}
	$retorno["icaoOrig"] = $origem;
	$retorno["icaoDest"] = $dest;
	$retorno["cidOrig"] = $cidOrigem;
	$retorno["cidDest"] = $cidDest;
	return $retorno;
}

function getCidade($icao, $con)
{
	$sql = "select cidade from icao where icao ='$icao'";
	$res = $con->query($sql);
	$qtd = $res->num_rows;

	if ($qtd > 0) {
		$row = $res->fetch_assoc();
		$retorno = $row['cidade'];
	} else $retorno = "ERRO: ICAO N&Atilde;O EXISTENTE";
	return $retorno;
}

function formataNumero1($numero)
{
	if (strlen($numero) == 1) {
		return '0' . $numero;
	} else
		return $numero;
}

function right($value, $count)
{
	$value = substr($value, (strlen($value) - $count), strlen($value));
	return $value;
}

function toRomano($N)
{
	$N1 = $N;
	$Y = "";
	while ($N / 1000 >= 1) {
		$Y .= "M";
		$N = $N - 1000;
	}
	if ($N / 900 >= 1) {
		$Y .= "CM";
		$N = $N - 900;
	}
	if ($N / 500 >= 1) {
		$Y .= "D";
		$N = $N - 500;
	}
	if ($N / 400 >= 1) {
		$Y .= "CD";
		$N = $N - 400;
	}
	while ($N / 100 >= 1) {
		$Y .= "C";
		$N = $N - 100;
	}
	if ($N / 90 >= 1) {
		$Y .= "XC";
		$N = $N - 90;
	}
	if ($N / 50 >= 1) {
		$Y .= "L";
		$N = $N - 50;
	}
	if ($N / 40 >= 1) {
		$Y .= "XL";
		$N = $N - 40;
	}
	while ($N / 10 >= 1) {
		$Y .= "X";
		$N = $N - 10;
	}
	if ($N / 9 >= 1) {
		$Y .= "IX";
		$N = $N - 9;
	}
	if ($N / 5 >= 1) {
		$Y .= "V";
		$N = $N - 5;
	}
	if ($N / 4 >= 1) {
		$Y .= "IV";
		$N = $N - 4;
	}
	while ($N >= 1) {
		$Y .= "I";
		$N = $N - 1;
	}
	return $Y;
}

function dataAtualPorExtenso()
{
	// leitura das datas
	$dia = date('d');
	$mes = date('m');
	$ano = date('Y');
	$semana = date('w');


	// configura&#65533;&#65533;o mes

	switch ($mes) {

		case 1:
			$mes = "janeiro";
			break;
		case 2:
			$mes = "fevereiro";
			break;
		case 3:
			$mes = "mar&ccedil;o";
			break;
		case 4:
			$mes = "abril";
			break;
		case 5:
			$mes = "maio";
			break;
		case 6:
			$mes = "junho";
			break;
		case 7:
			$mes = "julho";
			break;
		case 8:
			$mes = "agosto";
			break;
		case 9:
			$mes = "setembro";
			break;
		case 10:
			$mes = "outubro";
			break;
		case 11:
			$mes = "novembro";
			break;
		case 12:
			$mes = "dezembro";
			break;
	}


	// configura&#65533;&#65533;o semana
	switch ($semana) {
		case 0:
			$semana = "Domingo";
			break;
		case 1:
			$semana = "Segunda-feira";
			break;
		case 2:
			$semana = "Ter&ccedil;a-feira";
			break;
		case 3:
			$semana = "Quarta-feira";
			break;
		case 4:
			$semana = "Quinta-feira";
			break;
		case 5:
			$semana = "Sexta-feira";
			break;
		case 6:
			$semana = "S&aacute;bado";
			break;
	}

	//Agora basta imprimir na tela...
	return ("$semana, $dia de $mes de $ano");
}


function montaCabecalho($con)
{
	$sql = "select count(callsign) as qtd from piloto where status='a'";
	$res = $con->query($sql);
	$num_pilotos = $res->fetch_assoc();
	$num_pilotos = $num_pilotos["qtd"];

	//soma o numero total de horas na Cia.
	$sql = "select tempovoooffline,tempovoovatsim,tempovooivao,tempovoooutras,tempovoo_antes_ago2006 from dossie_piloto dp, piloto p where dp.callsign=p.callsign and p.status='a'";
	$res = $con->query($sql);
	$num_total_horas =  "00:00";
	while ($row = $res->fetch_assoc()) {
		$tempo1 = soma_horas($row["tempovoooffline"], $row['tempovoovatsim']);
		$tempo2 = soma_horas($tempo1, $row['tempovooivao']);
		$tempo3 = soma_horas($tempo2, $row['tempovoooutras']);
		$tempo4 = soma_horas($tempo3, $row['tempovoo_antes_ago2006']);
		$num_total_horas = soma_horas($num_total_horas, $tempo4);
	}

	//soma com os dados dos pilotos inativos antes de 10/08/2006
	$sql = "select horas_voadas_antes1008,horas_voadas_apos1008 from estatisticas where id=1";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	$horas_antes = $row["horas_voadas_antes1008"];
	$num_total_horas = soma_horas($num_total_horas, $horas_antes);

	$horas_apos = $row["horas_voadas_apos1008"];
	$num_total_horas = soma_horas($num_total_horas, $horas_apos);

	if (isset($_SESSION["callsign"])) {
		$cs  = $_SESSION["callsign"];
		$sql = "select * from dossie_piloto where callsign = $cs";
		$res = $con->query($sql);
		$row = $res->fetch_assoc();
		$dataUltimoVoo = ansi2br($row["data_ult_voo"]);

		$hoje = br2ansi(Date("d/m/y"));
		$data1 = montadata($dataUltimoVoo);
		$data2 = montadata($hoje);

		$qtd_dias = date_diff2($data1, $data2);

		if ($qtd_dias >= 90)
			$msg = " <span style=\"background:red;color:white\">Você está há mais de 90 dias sem voar!</span>";
		else {
			$msg = "";
		}
	} else
		$msg = "";

	$sql = "select count(cod_aeronave) as qtd from aeronave";
	$res = $con->query($sql);
	$num_aeronaves = $res->fetch_assoc();
	$num_aeronaves = $num_aeronaves["qtd"];
	$anoAtual = Date('Y');
	echo "Ano " . toRomano($anoAtual - 2003 + 1) . " - " . $num_total_horas . " horas de voo - ";
	echo $num_pilotos . " pilotos ativos - ";
	echo $num_aeronaves . " aeronaves" . $msg;
}

function truncate($num, $digits = 0)
{
	$shift = pow(10, $digits);
	return ((floor($num * $shift)) / $shift);
}

function madSafety($string)
{
	$string = stripslashes($string);
	$string = strip_tags($string);
	$string = mysql_real_escape_string($string);
	return $string;
}

function m2h($mins)
{
	return sprintf('%02d:%02d', floor($mins / 60), $mins % 60);
}

function contaPernasOp($numOp, $con)
{
	$sql = "select * from op where num_op=$numOp";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();

	$pernas = $row['escalas'];

	$perna = explode('-', $pernas);
	$qtd = count($perna);

	return $qtd - 1;
}

function mostraStatus($sta)
{
	switch ($sta) {
		case 1:
			$retorno = "Aguardando";
			break;
		case 2:
			$retorno = "Aprovado";
			break;
		case 3:
			$retorno = "Reprovado";
			break;
		case 4:
			$retorno = "Cancelado";
			break;
		case 5:
			$retorno = "Pendente";
			break;
	}
	return $retorno;
}

function getStatusOp($status)
{
	switch ($status) {
		case 'p':
			$retorno = "Aguarde Aprova&ccedil;&atilde;o";
			break;
		case 'a':
			$retorno = "Aprovada";
			break;
		case 'r':
			$retorno = "Reprovada";
			break;
		case 'c':
			$retorno = "Cancelada";
			break;
		case 'f':
			$retorno = "Finalizada";
			break;
	}
	return $retorno;
}

function getNomeGuerra($callsign, $con)
{
	$sql = "select * from piloto where callsign=$callsign";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();

	return $row['nome_guerra'];
}

function upload($target_dir)
{
	$target_file = SITE_ROOT . $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image

	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if ($check !== false) {
		$uploadOk = 1;
	} else {
		echo "O arquivo não é uma imagem.";
		$uploadOk = 0;
	}

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "O tamanho do arquivo é maior que 500000.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if (
		$imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif"
	) {
		echo "Somente JPG, JPEG, PNG & GIF são permitidos.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Upload NÃO foi feito.";
		exit();
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) { ?>
			<script>
				alert("O upload foi feito corretamente");
			</script>
<?php
		} else {
			echo "Erro no upload.";
			exit();
		}
	}
}

function GoToNow($url)
{
	echo '<script language="javascript">window.location.href ="' . $url . '"</script>';
}
?>