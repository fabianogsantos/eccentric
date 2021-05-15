<script>
    function voltar() {
        window.history.back();
    }
</script>
<?php

	if(!isset($_SESSION["callsign"])){
		?><script language="Javascript">
				window.open("index.php?pagina=pagina&pid=10","_parent");
		</script><?php
    	exit;
	}

	$callsign = $_SESSION["callsign"];

	$modo 				= $_POST['modo'];
	$tipo 				= $_POST['tipo'];
	empty($_POST['vooOficial'])?       $vooOficial=''      :$vooOficial=$_POST['vooOficial'];
	empty($_POST['vooExtraOficial'])?  $vooExtraOficial='' :$vooExtraOficial=$_POST['vooExtraOficial'];
	empty($_POST['icaoOrigem'])?       $icaoOrigem=''      :$icaoOrigem=$_POST['icaoOrigem'];
	empty($_POST['icaoDestino'])?      $icaoDestino=''     :$icaoDestino=$_POST['icaoDestino'];
	empty($_POST['perna'])?            $perna=''           :$perna=strtoupper($_POST['perna']);

	$tempoVoo 			= $_POST['tempo_voo'];
	$dataPartida 		= $_POST['data_partida'];
	$codAeronave 		= $_POST['cod_aeronave'];
	$distancia			= $_POST['distancia'];
	$altitude 			= $_POST['altitude'];
	$combustivel 		= $_POST['combustivel'];
	$planoVoo 			= $_POST['plano'];
	$motivo 			  = "";
	$validado       = FALSE;

	echo "<h3>Resumo do Relatório</h3><hr>";

	if (empty($modo)){
    $validado = (isset($validado)) ? FALSE : TRUE;
	}
	else {
		//echo "<strong>Modo: </strong>".trataModo($modo);
	}

	//pega dados da aeronave
	$sqlA = "select * from aeronave where cod_aeronave = $codAeronave";
	$resA = $con->query($sqlA);
	$rowA = $resA->fetch_assoc();

	$kts_cruz = $rowA['kts_cruz'];
	$min_adic = $rowA['min_adic'];

	//calcula tempo maximo de voo
	if ($modo=='o') $fator = 20; else $fator = 60;

	$tempoDeVoo = explode(":",$tempoVoo);
	$horas = $tempoDeVoo[0];
	$minutos = $tempoDeVoo[1];
	$minutosVoados = floatval($horas*60+$minutos);

	$tempoMaxVoo = floatval($distancia/$kts_cruz*60 +$min_adic+$fator);
	$tempoMaxVooH = m2h($tempoMaxVoo);

	if ($tempoMaxVoo<=$minutosVoados) {
    $validado = (isset($validado)) ? FALSE : TRUE;
		$motivo = "Refaça os dados de seu relatório, pois o tempo de voo está ultrapassando o limite previsto no art. 35 do Regulamento Geral.<br> Na forma que está, o tempo máximo permitido é: ".$tempoMaxVooH.".";
	}
	else {
        $validado = (isset($validado)) ? TRUE : FALSE;
  }

	$hoje = Date("d/m/Y");
	if (strtotime(br2ansi($dataPartida))>strtotime(br2ansi($hoje))){
    $validado = false;
		$motivo = "Refaça os dados de seu relatório, pois a data da partida informada é maior que a data de hoje.";
	}

	//verifica se eh voo oficial
	if (!empty($vooOficial)){
		//É oficial! verifica se preencheu icao
		if(!empty($icaoOrigem)||!empty($icaoDestino)){
      $validado = false;
      $motivo = $motivo . "ICAO não preenchido";
      $stringSaida = "ICAO não preenchido";
		}
		else {
			$icaos = array();
			$icaos = getIcaos($vooOficial,$con);
			$saidaVooOficial = $vooOficial." - ".$icaos["icaoOrig"]."/".$icaos["icaoDest"]." - ".$icaos["cidOrig"]."/".$icaos["cidDest"];
			$numeroVoo = $vooOficial;
			$icaoOrigem = $icaos["icaoOrig"];
			$icaoDestino = $icaos["icaoDest"];
      $cidOrigem = $icaos["cidOrig"];
      $cidDestino = $icaos["cidDest"];
		}
	}
	else {
	    //verificacao da quantidade de pernas
        //verifica se é OP
      if (strtoupper(substr($vooExtraOficial,0,2))=='OP'){
          //verifica quantas pernas existem na OP
        $sql = "select * from op where callsign=$callsign and status='a'";
        $res = $con->query($sql);
	      $pernas = $res->fetch_assoc();
		  $pernas =$pernas['nropernas'];

  			if ($pernas==1 && strtolower($perna)!='FE'){
  				$validado = (isset($validado)) ? FALSE : $validado;
                  $motivo = $motivo . "Quando a OP tiver apenas 1 perna, digite 'FE";
  			}
  			else {
  				if ($perna!='FE'){
  					if ($perna>$pernas && $pernas>1){
  						$validado = (isset($validado)) ? FALSE : $validado;
  						$motivo = $motivo . "O número da perna enviado é maior do que o número de pernas da OP";
  					}
  					else {
  						if ($perna==""){
  							$perna = "N&Atilde;O PREENCHIDO";
  							$motivo = $motivo."Número da perna da ME n&atilde;o preenchido.";
  							$validado = (isset($validado)) ? FALSE : $validado;
  						}
  					}
  				}
			  }
      }
      else {
        if (strtoupper(substr($vooExtraOficial,0,2))=='ME'){
          $numero_me = substr($vooExtraOficial,2,2);
          $sql = "select * from me where cod=$numero_me and status=1";
          $res = $con->query($sql);
          $pernas = $res->fetch_assoc();
		  $pernas =$pernas['nropernas'];

          if ($pernas==1 && strtolower($perna)!='FE'){
            $validado = (isset($validado)) ? FALSE : $validado;
            $motivo = $motivo . "Quando a ME tiver apenas 1 perna, digite 'FE";
          }
        else {
          if ($perna!='FE'){
            if ($perna>$pernas && $pernas>1){
              $validado = (isset($validado)) ? FALSE : $validado;
              $motivo = $motivo . "O número da perna enviado é maior do que o número de pernas da OP";
            }
            else {
              if ($perna==""){
                $perna = "N&Atilde;O PREENCHIDO";
                $motivo = $motivo."Número da perna da ME n&atilde;o preenchido.";
                $validado = (isset($validado)) ? FALSE : $validado;
              }
            }
          }
        }
      }
    }

    if  (empty($icaoOrigem)){
      $cidOrigem = "NAO PREENCHIDO";
      $validado = (isset($validado)) ? FALSE : $validado;
    }
    else  {
      $cidOrigem = getCidade($icaoOrigem,$con);
    }

    if ($cidOrigem == "ERRO-ICAO NÃO EXISTENTE"){
      $motivo = $motivo."ICAO de origem inválido. Se o Icao é mesmo o informado, entre em contato com o Presidente por e-mail.";
      $validado = (isset($validado)) ? FALSE : $validado;
    }

    if (empty($icaoDestino)){
      $cidDestino = "NAO PREENCHIDO";
      $validado = (!isset($validado)) ? FALSE : $validado;
    }
    else {
      $cidDestino = getCidade($icaoDestino,$con);
    }

    if ($cidDestino == "ERRO-ICAO N&Atilde;O EXISTENTE"){
      $motivo = $motivo."ICAO de destino inválido. Se o Icao é mesmo o informado, entre em contato com o Presidente por e-mail.";
      $validado = (isset($validado)) ? FALSE : $validado;
    }

    $tipos = array("op","me","mp","re");

    if (in_array(substr($vooExtraOficial,0,2),$tipos)){
      $stringSaida = strtoupper($vooExtraOficial)."/".$perna." - ".strtoupper($icaoOrigem)."/".$cidOrigem." - ".strtoupper($icaoDestino)."/".$cidDestino;
    }

    $numeroVoo=$vooExtraOficial."/".$perna;

    $extras = array("ast01","ast02","frt01","frt02","tst","itn01","itn02","trs");
    if (in_array($vooExtraOficial,$extras)){
      $stringSaida = strtoupper($vooExtraOficial)." - ".strtoupper($icaoOrigem)."/".$cidOrigem." - ".strtoupper($icaoDestino)."/".$cidDestino;
      $numeroVoo=$vooExtraOficial;
      $validado = TRUE;
    }
	}

 	if ($validado){
    echo "<div class=\"alert alert-success\">
      <strong>Ok!</strong> Seu relatório está correto. Pode <strong>Confirmar</strong> para efetiva-lo.
      </div>";
 	}
 	else {
    echo "<div class=\"alert alert-danger\">
      <strong>Erro:</strong> Seu relatório contém algum tipo de erro. Volte e corrija.
      </div>";
    echo "<div class=\"alert alert-warning\">
      <strong>Erro:</strong> ".$motivo."</div>";
 	}

  echo "<table class=\"table table-striped table-hover table-responsive table-condensed\">
<tbody>";

  if (!empty($vooOficial)){
      echo "<tr><td><strong>Voo oficial:</strong></td><td>".$saidaVooOficial."</td></tr>";
  }
  else {
      echo "<tr><td><strong>Voo Extra-oficial:</strong></td><td>".$stringSaida."</td></tr>";
  }


  echo "	<tr><td><strong>Modo:</strong></td><td>".trataModo($modo)."</td></tr>
	<tr><td><strong>Aeronave:</strong></td><td>".getAeronave($codAeronave,$con)."</td></tr>
	<tr><td><strong>Tempo de voo:</strong></td><td>".$tempoVoo."</td></tr>
	<tr><td><strong>Data da partida:</strong></td><td>".ansi2br($dataPartida)."</td></tr>
	<tr><td><strong>Distância:</strong></td><td>".$distancia." nm</td></tr>
	<tr><td><strong>Nível de voo:</strong></td><td>FL".$altitude."</td></tr>
	<tr><td><strong>Combustível:</strong></td><td>".$combustivel." gal</td></tr>
	<tr><td><strong>Plano de voo:</strong></td><td>".trataPlanoVoo($planoVoo)."</td></tr>
	<tr><td><strong>ICAO Origem:</strong></td><td>".strtoupper($icaoOrigem)."-".$cidOrigem."</td></tr>
	<tr><td><strong>ICAO Destino:</strong></td><td>".strtoupper($icaoDestino)."-",$cidDestino."</td></tr>
</tbody></table>";

if ($validado){
	echo "<form id=\"form1\" name=\"form1\" method=\"post\" action=\"index.php?pagina=relatorios/confirmaRelatorio\">";
	echo "<input name=\"modo\" type=\"hidden\" value=\"".$modo."\" />";
	echo "<input name=\"tipo\" type=\"hidden\" value=\"".$tipo."\" />";
	echo "<input name=\"numeroVoo\" type=\"hidden\" value=\"".$numeroVoo."\" />";
	echo "<input name=\"icaoOrigem\" type=\"hidden\" value=\"".strtoupper($icaoOrigem)."\" />";
	echo "<input name=\"icaoDestino\" type=\"hidden\" value=\"".strtoupper($icaoDestino)."\" />";
	echo "<input name=\"dataPartida\" type=\"hidden\" value=\"".$dataPartida."\" />";
	echo "<input name=\"tempoVoo\" type=\"hidden\" value=\"".$tempoVoo."\" />";
	echo "<input name=\"codAeronave\" type=\"hidden\" value=\"".$codAeronave."\" />";
	echo "<input name=\"distancia\" type=\"hidden\" value=\"".$distancia."\" />";
	echo "<input name=\"altitude\" type=\"hidden\" value=\"".$altitude."\" />";
	echo "<input name=\"combustivel\" type=\"hidden\" value=\"".$combustivel."\" />";
	echo "<input name=\"planoVoo\" type=\"hidden\" value=\"".$planoVoo."\" />";
}

if ($validado)
    echo "<button type=\"submit\" class=\"btn btn-primary\">Confirmar</button>";
?>
<button type="button" class="btn btn-danger" onclick="voltar()">Voltar</button>
</form>
