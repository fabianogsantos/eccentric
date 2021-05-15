<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $data = $_POST['data'];
    $texto = $_POST['texto'];

    $sql = "INSERT into noticia (data,texto) values ('$data','$texto')";

    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=noticias/noticias";
    echo "<script>window.location = \"".$url."\"</script>";
}
?>
<div class="page-header">
  <h3>Cadastro de Notícias</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=noticias/insere";?>">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="data">Data</label>
          <input class="form-control"  type="date" name="data" id="data">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10">
        <div class="form-group">
          <label for="texto">Texto</label>
          <textarea name="texto" id="texto" cols="30" rows="10" class="form-control"></textarea>
        </div>
      </div>
    </div>
  <br><br>
  <input class="btn btn-primary"  name="Submit" type="submit" value="Salvar">
</form>
