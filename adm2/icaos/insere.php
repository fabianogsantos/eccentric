<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $icao = $_POST['icao'];
    $cidade = $_POST['cidade'];

    $sql = "INSERT into icao (icao,cidade) values ('$icao','$cidade')";

    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=icaos/icaos";
    echo "<script>window.location = \"".$url."\"</script>";
}
?>
<div class="page-header">
  <h3>Cadastro de ICAOs</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=icaos/insere";?>">
    <div class="row">
      <div class="col-md-2">
        <div class="form-group">
          <label for="icao">ICAO</label>
          <input class="form-control"  type="text" name="icao" id="icao">
        </div>
      </div>
      <div class="col-md-10">
        <div class="form-group">
          <label for="prefixo">Cidade</label>
          <input class="form-control"  name="cidade" type="text" id="cidade" >
        </div>
      </div>
    </div>
  <br><br>
  <input class="btn btn-primary"  name="Submit" type="submit" value="Gravar!">
</form>
