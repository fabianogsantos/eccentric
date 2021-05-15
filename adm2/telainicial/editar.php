<?php
	include("../conecta.php");

	$sql = "select imagem from homepage where id=1";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	$conteudo = $row['imagem'];

?>
<div class="page-header">
  <h3>Editar home page</h3>
</div>
<p>Imagem atual:</p>
<img src="<?php echo $conteudo?>" >
<hr>
<form action="index.php?pagina=telainicial/upload" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="fileToUpload">Imagem para upload (900x400px)</label>
		<input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
	</div>
	<div class="form-group">
		<label for="legenda">Legenda</label>
		<textarea name="legenda" cols="80" rows="10" class="form-control"></textarea>
	</div>
	<input type="submit" value="Enviar" name="submit" class="btn btn-primary">
</form>
