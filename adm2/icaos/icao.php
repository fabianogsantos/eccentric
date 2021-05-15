<?php
if ($_SERVER['REQUEST_METHOD']=='GET'){
  $icao = $_GET['icao'];

  $query = "SELECT * FROM icao where icao='$icao'";
  $rs = $con->query($query);
  $row = $rs->fetch_assoc();
  $totalRows = $rs->num_rows;
}
else {
  if ($_SERVER['REQUEST_METHOD']=='POST'){
    $icao = $_POST['icao'];
    $cidade = $_POST['cidade'];
    
    $sql = "UPDATE icao SET icao='$icao' where icao = '$icao'";
    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=icaos/icaos";
    echo "<script>window.location = \"".$url."\"</script>";
  }
}
?>
<div class="page-header">
  <h3>Cadastro de ICAOs</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=icaos/icao";?>">
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="cod_aeronave">ICAO</label>
        <input class="form-control"  type="text" name="icao" value="<?php echo $row['icao']; ?>" readonly>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="form-group">
        <label for="cidade">Aeródromo</label>
        <input class="form-control"  type="text" name="cidade" value="<?php echo $row['cidade']; ?>"  >
      </div>
    </div>
  </div>
  <input class="btn btn-primary"  name="Submit" type="submit" value="Gravar">
  <a href="index.php?pagina=icaos/apaga&icao=<?=$icao?>" class="btn btn-danger"  role="button">Apagar</a>
</form>
