<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $num = $_GET['num'];

  $query = "SELECT * FROM voooficial where num='$num'";
  $rs = $con->query($query);
  $row = $rs->fetch_assoc();
  $totalRows = $rs->num_rows;
} else {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num            = $_POST['num'];
    $num_new        = $_POST['num_new'];
    $icaoorigem     = $_POST['icaoorigem'];
    $icaodestino    = $_POST['icaodestino'];
    $vooanterior    = $_POST['vooanterior'];
    $nucleo         = $_POST['nucleo'];
    $posto          = $_POST['posto'];


    $sql = "UPDATE voooficial SET num='$num_new', 
                    icaoorigem ='$icaoorigem', 
                    icaodestino ='$icaodestino', 
                    vooanterior ='$vooanterior', 
                    nucleo ='$nucleo', 
                    posto ='$posto' where num = '$num'";
    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF'] . "?pagina=voos/voos";
    echo "<script>window.location = \"" . $url . "\"</script>";
  }
}
?>
<div class="page-header">
  <h3>Cadastro de Voos Oficiais</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?pagina=voos/voo"; ?>">
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="num">Número</label>
        <input class="form-control" type="text" name="num_new" value="<?php echo $row['num']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="icaoorigem">ICAO Origem</label>
        <input class="form-control" type="text" name="icaoorigem" value="<?php echo $row['icaoorigem']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="icaodestino">ICAO Destino</label>
        <input class="form-control" type="text" name="icaodestino" value="<?php echo $row['icaodestino']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="vooanterior">Voo Anterior</label>
        <input class="form-control" type="text" name="vooanterior" value="<?php echo $row['vooanterior']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="nucleo">Núcleo</label>
        <input class="form-control" type="text" name="nucleo" value="<?php echo $row['nucleo']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="posto">Posto</label>
        <input class="form-control" type="text" name="posto" value="<?php echo $row['posto']; ?>">
      </div>
    </div>
  </div>
  <input class="btn btn-primary" name="Submit" type="submit" value="Gravar">
  <input type="hidden" name="num" value="<?php echo $row['num']; ?>">
  <a href="index.php?pagina=voos/apaga&num=<?= $num ?>" class="btn btn-danger" role="button">Apagar</a>
</form>