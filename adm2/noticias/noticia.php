<?php
if ($_SERVER['REQUEST_METHOD']=='GET'){
  $id = $_GET['id'];

  $query = "SELECT id, data, texto from noticia where id='$id'";
  $rs = $con->query($query);
  $row = $rs->fetch_assoc();
  $totalRows = $rs->num_rows;
}
else {
  if ($_SERVER['REQUEST_METHOD']=='POST'){
    $icao = $_POST['id'];
    $data = $_POST['data'];
    $texto = $_POST['texto'];
    
    $sql = "UPDATE noticia SET id='$id', data='$data', texto=$texto where id = '$id'";
    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=noticias/noticias";
    echo "<script>window.location = \"".$url."\"</script>";
  }
}
?>
<div class="page-header">
  <h3>Cadastro de Notícias</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=noticias/noticia";?>">
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="id">Número</label>
        <input class="form-control"  type="text" name="id" value="<?php echo $row['id']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="form-group">
        <label for="cidade">Data</label>
        <input class="form-control"  type="date" name="data" value="<?php echo $row['data']; ?>"  >
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <label for="texto">Texto</label>
      <textarea name="texto" id="texto" cols="30" rows="10" class="form-control" value="<?php echo $row['texto']; ?>></textarea>
    </div>
  </div>
  <input class="btn btn-primary"  name="Submit" type="submit" value="Gravar">
  <a href="index.php?pagina=noticias/apaga&id=<?=$id?>" class="btn btn-danger"  role="button">Apagar</a>
</form>
