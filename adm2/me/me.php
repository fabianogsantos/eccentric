<?php
if ($_SERVER['REQUEST_METHOD']=='GET'){
  $cod = $_GET['cod'];

  $query = "SELECT * FROM me where cod='$cod'";
  $rs = $con->query($query);
  $row = $rs->fetch_assoc();
  $totalRows = $rs->num_rows;
}
else {
  if ($_SERVER['REQUEST_METHOD']=='POST'){
    $cod = $_POST['cod'];
    $nome     = $_POST['nome'];

    if (!empty($_FILES['fileToUpload']["name"])){
      $imagem   = $_FILES['fileToUpload']["name"];
      upload('../imagens/me/');
      $sql = "UPDATE me SET nome='$nome', imagem='$imagem' where cod = '$cod'";
    }
    else $sql = "UPDATE me SET nome='$nome' where cod = '$cod'"; 
    
    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=me/mes";
    echo "<script>window.location = \"".$url."\"</script>";
  }
}
?>
<div class="page-header">
  <h3>Missão especial</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=me/me";?>" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="cod">Código</label>
        <input class="form-control"  type="text" name="cod" value="<?php echo $row['cod']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input class="form-control"  type="text" name="nome" value="<?php echo $row['nome']; ?>"  >
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="form-group">
        <label for="fileToUpload">Imagem</label>
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
        <br>
        <img src="../imagens/me/<?=$row['imagem']?>" alt="<?=$row['nome']?>" >
      </div>
    </div>
  </div>
  <input class="btn btn-primary" name="submit" type="submit" value="Salvar">
  <a href="index.php?pagina=me/apaga&cod=<?=$cod?>" class="btn btn-danger"  role="button">Apagar</a>
</form>
