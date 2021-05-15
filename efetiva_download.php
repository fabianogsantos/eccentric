<?
	require_once("conecta.php");
	include('funcoes.php');
	
	$id = $_POST['id'];
	
	$hoje = br2ansi(date("d/m/Y",time()));

	
	if ($motivo <> 'a')
		switch ($motivo) {
			case "c":
				$sql = "update op set status='c', motivo='$motivo', data_aprova = '$hoje' where id=$id";
				break;
			case "f":
				$sql = "update op set status='f', motivo='$motivo', data_aprova = '$hoje' where id=$id";
				break;
			default:
				$sql = "update op set status='r', motivo='$motivo', data_aprova = '$hoje' where id=$id";
				break;								
		}
	else{
		//verifica o numero da ultima op concedida
		$sql = "select max(num_op) as numero from op";
		$res = mysql_query($sql);
		$row = mysql_fetch_assoc($res);
		
		$numero = $row['numero'];
		$numero = $numero + 1;
		$sql = "update op set status='a', motivo='x', data_aprova = '$hoje', num_op=$numero where id=$id";
	}		
	$res = mysql_query($sql);
	@$row = mysql_fetch_assoc($res);
	

  	if ($motivo=='a'){
		?>
		<script language="Javascript">
			var numero = <? echo $numero; ?>;
			alert("OP Aprovada. Número = "+numero);
			window.open("index.php?pagina=adm_ops","_self");
		</script>  
        <?
	}        
	if ($motivo=='c'){
		?>
		<script language="Javascript">
			var numero = <? echo $numero; ?>;
			alert("OP Cancelada.");
			window.open("index.php?pagina=adm_ops","_self");
		</script>  
        <?
	}  
	if ($motivo=='f'){
		?>
		<script language="Javascript">
			alert("OP Finalizada.");
			window.open("index.php?pagina=adm_ops","_self");
		</script>  
        <?
	}          
    else{
		?>
		<script language="Javascript">
			alert("OP Reprovada.");
			window.open("index.php?pagina=adm_ops","_self");
		</script> 
        <? 
	}
?>    