<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $nome       = $_POST['nome'];
    $imagem     = 'imagens/rev/'.$_FILES['fileToUpload']["name"];

    upload('/etr/imagens/rev/');

    $sql = "INSERT into rev (nome,imagem) values ('$nome','$imagem')";

    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=revoadas/revoadas";
    echo "<script>window.location = \"".$url."\"</script>";
}
?>
<div class="page-header">
  <h3>Cadastro de Revoada</h3>
</div>
<form method="post" name="formPais" id="formPais" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=revoadas/insere";?>"  enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="nome">Nome</label>
          <input class="form-control"  type="text" name="nome" id="nome" required>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <div class="form-group">
                <label for="imagem">Imagem</label>
                <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .png">
            </div>
        </div>
    </div>
    <div class="form-group">
        <input class="btn btn-primary"  name="Submit" type="submit" value="Gravar">
    </div>
</form>
