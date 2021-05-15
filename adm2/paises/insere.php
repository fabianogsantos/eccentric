<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $nome       = $_POST['nome'];
    $imagem     = 'imagens/pais/'.$_FILES['fileToUpload']["name"];

    upload('/imagens/pais/');

    $sql = "INSERT into pais (nome,imagem) values ('$nome','$imagem')";

    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=paises/paises";
    echo "<script>window.location = \"".$url."\"</script>";
}
?>
<div class="page-header">
  <h3>Cadastro de País</h3>
</div>
<form method="post" name="formPais" id="formPais" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=paises/insere";?>"  enctype="multipart/form-data">
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
                <label for="imagem">Bandeira</label>
                <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .png">
            </div>
        </div>
    </div>
    <div class="form-group">
        <input class="btn btn-primary"  name="Submit" type="submit" value="Gravar">
    </div>
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div id="targeLayer" style="display:none;"></div>
</form>
<div id="loader-icon" style="display:none;">Carregando...</div>
