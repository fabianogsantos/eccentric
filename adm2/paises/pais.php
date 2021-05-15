<?php
if ($_SERVER['REQUEST_METHOD']=='GET'){
  $cod_pais = $_GET['cod_pais'];

  $query = "SELECT * FROM pais where cod_pais='$cod_pais'";
  $rs = $con->query($query);
  $row = $rs->fetch_assoc();
  $totalRows = $rs->num_rows;
}
else {
  if ($_SERVER['REQUEST_METHOD']=='POST'){
    $cod_pais = $_POST['cod_pais'];
    $nome     = $_POST['nome'];

    if (!empty($_FILES['fileToUpload']["name"])){
      $imagem   = 'imagens/pais/'.$_FILES['fileToUpload']["name"];
      upload('/imagens/pais/');
      $sql = "UPDATE pais SET nome='$nome', imagem='$imagem' where cod_pais = '$cod_pais'";
    }
    else $sql = "UPDATE pais SET nome='$nome' where cod_pais = '$cod_pais'"; 
  
    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=paises/paises";
    echo "<script>window.location = \"".$url."\"</script>";
  }
}
?>
<div class="page-header">
  <h3>Cadastro de Países</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=paises/pais";?>" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="cod">Código</label>
        <input class="form-control" type="text" name="cod_pais" value="<?php echo $row['cod_pais']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input class="form-control" type="text" name="nome" value="<?php echo $row['nome']; ?>"  >
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="form-group">
        <label for="fileToUpload">Bandeira</label>
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
        <br>
        <img src="../<?=$row['imagem']?>" alt="<?=$row['nome']?>" >
      </div>
    </div>
  </div>
  <input class="btn btn-primary" name="submit" type="submit" value="Salvar">
  <a href="index.php?pagina=paises/apaga&cod_pais=<?=$cod_pais?>" class="btn btn-danger"  role="button">Apagar</a>
</form>
