<?php
	include("../conecta.php");

	$sql = "select imagem from homepage where id=1";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	$conteudo = $row['imagem'];

?>
<p>Imagem atual:</p>
<img src="<?php echo $conteudo?>" >
<hr>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <p>Selecione a imagem para upload. <strong>Tamanho recomendado: 1000x350</strong></p>
    <p><input type="file" name="fileToUpload" id="fileToUpload"></p>
    <p>Legenda:</p>
    <p><textarea name="legenda" cols="80" rows="10"></textarea></p>
    <input type="submit" value="Enviar" name="submit">
</form>
