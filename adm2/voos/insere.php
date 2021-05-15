<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deu_pau        = false;
    $num            = $_POST['num'];
    $icaoorigem     = strtoupper($_POST['icaoorigem']);
    $icaodestino    = strtoupper($_POST['icaodestino']);
    $vooanterior    = $_POST['vooanterior'];
    $nucleo         = $_POST['nucleo'];
    $posto          = $_POST['posto'];

    $sql = "Insert into voooficial (num, icaoorigem, icaodestino, vooanterior, nucleo, posto) values ('" . $num . "','" . strtoupper($icaoorigem) . "','" . strtoupper($icaodestino) . "','" . $vooanterior . "','" . strtolower($nucleo) . "','" . $posto . "')";
    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF'] . "?pagina=voos/voos";
    echo "<script>window.location = \"" . $url . "\"</script>";
}

?>
<div class="page-header">
    <h3>Cadastro de Rotas</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?pagina=voos/insere"; ?>">
    <div class="form-group">
        <label for="num">Número</label>
        <input class="form-control" type="text" name="num">
    </div>
    <div class="form-group">
        <label for="icaoorigem">ICAO Origem</label>
        <input type="text" name="icaoorigem" id="icaoorigem" class="form-control">
    </div>
    <div class="form-group">
        <label for="icaodestino">ICAO Destino</label>
        <input type="text" name="icaodestino" id="icaodestino" class="form-control">
    </div>
    <div class="form-group">
        <label for="vooanterior">Voo Anterior</label>
        <input class="form-control" type="text" name="vooanterior">
    </div>
    <div class="form-group">
        <label for="nucleo">Núcleo</label>
        <select name="nucleo" id="" class="form-control">
            <option value="bh">Belo Horizonte</option>
            <option value="rf">Recife</option>
            <option value="rj">Rio de Janeiro</option>
            <option value="sp">São Paulo</option>
        </select>
    </div>
    <div class="form-group">
        <label for="posto">Posto</label>
        <select name="posto" id="" class="form-control">
            <?php
            $sql = "select * from posto";
            $res = $con->query($sql);

            while ($row = $res->fetch_assoc()) {
                echo "<option value=\"" . $row['cod_posto'] . "\">" . $row['nome_posto'] . "</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Gravar</button>
</form>