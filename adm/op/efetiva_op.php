<?php
	$id 			= $_POST['idop'];
	$escalas 		= $_POST['escalas'];
	$nropernas 		= $_POST['nropernas'];
	$motivo 		= $_POST['motivo'];
	$callsign 		= $_POST['callsign'];
	$hoje 			= br2ansi(date("d/m/Y",time()));
	$datapedido 	= br2ansi($_POST['datapedido']);
	$cod_aeronave 	= $_POST['cod_aeronave'];

	/*
	Motivos
	"a" selected>Aprovar</option>
	"c">Cancelar</option>
	"f">Finalizar</option>
	"1">Reprovar - Preench. incorreto solicita��o</option>
	"2">Reprovar - Posto do piloto n�o autorizado</option>
	"3">Reprovar - Anv. incompat. com o posto</option>
	"4">Reprovar - Anv. incompat. com algum aeroporto</option>
	"5">Reprovar - Piloto tem outra rota n�o finalizada</option>
	"6">Reprovar - Outros motivos</option>
	*/

	if ($motivo <> 'a'){
		switch ($motivo) {
			case "c":
				$sql = "update op set status='c', motivo='$motivo', data_aprova = '$hoje' where id=$id";
				break;
			case "f":
				$sql = "update op set status='f', motivo='$motivo', data_aprova = '$hoje' where id=$id";
				break;
      case "d":
        $sql = "delete from op where id=$id";
        break;
			default:
				$sql = "update op set status='r', motivo='$motivo', data_aprova = '$hoje' where id=$id";
				break;
		};
		$res = $con->query($sql);
	}
	else{
		//verifica se o piloto tem op n�o finalizada
		$sql = "SELECT * FROM op WHERE callsign = $callsign and status='a'";
		$res = $con->query($sql);
		$num = $res->num_rows;

		if ($num>0){
      echo "<h3>Erro!</h3>";
			echo "<p>O piloto j&aacute; possui uma OP Aberta. Verifique.</p>";
		}
		else {
			//verifica o numero da ultima op concedida
			$sql = "select max(num_op) as numero from op";
			$res = $con->query($sql);
			$row = $res->fetch_assoc();

			$numero = $row['numero'];
			$numero = $numero + 1;
			$sql = "update op set status='a', motivo='x', data_aprova = '$hoje', num_op=$numero, escalas='$escalas', nropernas=$nropernas, cod_aeronave=$cod_aeronave,data_pedido='$datapedido' where id=$id";
			$res = $con->query($sql);

			//cria os voos na tabela flight para o xacars
      /*
			$numPernas = contaPernasOp($numero);
			$sql = "select * from op where num_op=$numero";
      $res = $con->query($sql);
      $row = $res->fetch_assoc();
			$pernas = $row['escalas'];
			$cod_aeronave = $row['cod_aeronave'];
			$perna = explode('-',$pernas);

			for ($i=1; $i<=$numPernas; $i++){
				$departure = $perna[$i-1];
				$destination = $perna[$i];
				$flightnumber = $numero."_".$i;
				$sqli = "insert into flights (aircraft,departure,destination,flightnumber) values ('$cod_aeronave','$departure','$destination','$flightnumber')";
				$resi = $con->query($sqli);
			}
      */
		}
	}

	switch ($motivo) {
		case 'a':
      echo "<h3>OP Aprovada</h3>";
      echo "<p>N&uacute;mero da OP concedida: ".$numero."</p>";
      echo "<a href='index.php?pagina=op/ops' class='button'><button>Gest&atilde;o de OPS</button></a>";
			break;
		case 'c':
      echo "<h3>OP cancelada</h3>";
      echo "<a href='index.php?pagina=op/ops' class='button'><button>Gest&atilde;o de OPS</button></a>";
      break;
    case 'f':
      echo "<h3>OP finalizada</h3>";
      echo "<a href='index.php?pagina=op/ops' class='button'><button>Gest&atilde;o de OPS</button></a>";
      break;
    case 'd':
      echo "<h3>OP apagada do banco de dados</h3>";
      echo "<a href='index.php?pagina=op/ops' class='button'><button>Gest&atilde;o de OPS</button></a>";
      break;
		default:
      echo "<h3>OP reprovada</h3>";
      echo "<a href='index.php?pagina=op/ops' class='button'><button>Gest&atilde;o de OPS</button></a>";
      break;
	}
?>
