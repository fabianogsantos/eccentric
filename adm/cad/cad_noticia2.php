<?php
$num = $_GET['num'];
$opcao = $_GET['opcao'];

if (($opcao=='ins' || $opcao='upd') && $_SERVER['REQUEST_METHOD']=='POST'){
	$conteudo = $_POST['conteudo'];
	if ($num>0){
		$sql = "update noticia set texto='$conteudo' where id = $num";
	}
	else{
		$data = br2ansi($_POST['data']);	
		$sql = "insert into noticia (texto,data) values('$conteudo', '$data')";
	}
	$Result1 = $con->query($sql);
	
	?>
	<script language="Javascript">
		alert("Dados gravados!");
		window.open("index.php?pagina=adm_noticias","_self");
	</script>
	<?php
}
else if ($opcao == 'upd'){
	$sql = "select texto,data from noticia where id = $num";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	$conteudo = $row['texto'];
	$data = ansi2br($row['data']);
}	
?>

<h1>Cadastro de Not&iacute;cias</h1>
<form action="<?php echo $_SERVER['PHP_SELF'].'?pagina=cad/cad_noticia2&opcao=$opcao&num=$num';?>" method="post">
	<p>Data da not&iacute;cia: 
	<input name="data" type="text" size="10" maxlength="10" value="<?php if ($num>0) echo $data; else echo date("d/m/Y");?>"> <input type="submit" value="Enviar"></p>
	<p><textarea  cols='80' id='editor1' name='conteudo' rows='20'>
		<?php 
			if ($opcao=='upd') 
				echo $conteudo;
			else
				echo ''; ?></textarea></p>
	
</form>


