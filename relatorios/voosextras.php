<?php
session_start();
include '../conecta.php';
include '../funcoes.php';

if (!isset($_SESSION["callsign"])) {
?><script language="Javascript">
        window.open("index.php?pagina=pagina&pid=10", "_parent");
    </script><?php
                exit;
            }

            $callsign = $_GET["callsign"];
            $sql = "select * from piloto where callsign = $callsign";
            $res = $con->query($sql);
            $row = $res->fetch_assoc();
            $posto = $row["cod_posto"];
            $nucleo = $row["nucleo"];

            //verifica se tem alguma ME ativa, se tem coloca na lista
            $sqlME = "SELECT * FROM me WHERE STATUS = 1";
            $resME = $con->query($sqlME);
            $rowME = $resME->fetch_assoc();
            $temME = $resME->num_rows;


            if ($temME > 0) {
                $nroPernasME =  $rowME['nropernas'];
                $codME = formataNumero1($rowME['cod']);
            } else {
                $nroPernasME = 0;
            }

            //verifica se tem algum MP ativo, se tem coloca na lista
            $sqlMP = "SELECT * FROM mp WHERE STATUS = 1";
            $resMP = $con->query($sqlMP);
            $rowMP = $resMP->fetch_assoc();
            $temMP = $resMP->num_rows;
            if ($temMP > 0) {
                $numeroMP = formataNumero1($rowMP['cod']);
            }

            //verifica se tem alguma Revoada ativa, se tem coloca na lista
            $sqlRev = "SELECT * FROM rev WHERE STATUS = 1";
            $resRev = $con->query($sqlRev);
            $rowRev = $resRev->fetch_assoc();
            $temRev = $resRev->num_rows;
            if ($temRev > 0) {
                $numeroRev = formataNumero1($rowRev['cod']);
            }

            $sqlOP = "select * from op where status = 'a' and callsign=$callsign";
            $resOP = $con->query($sqlOP);
            $rowOP = $resOP->fetch_assoc();
            $temOP = $resOP->num_rows;

            if ($temOP > 0) {
                $nroPernasOP = $rowOP['nropernas'];
                $numOP = formataNumero1($rowOP['num_op']);
            } else {
                $nroPernasOP = 0;
            }
                ?>

<div class="form-group">
    <label class="control-label col-sm-2" for="vooExtraOficial">Selecione o voo: </label>
    <div class="col-sm-4">
        <select class="form-control" name="vooExtraOficial" id="vooExtraOficial">
            <option value="">Selecione</option>
            <!--<option value="itn01">ITN01</option>-->
            <!--<option value="itn02">ITN02</option>-->
            <option value="tst">TST</option>
            <option value="trs">TRS</option>
            <?php
            if ($temOP > 0) {
                echo "<option value=\"op" . $numOP . "\">OP" . $numOP . "</option>";
            }
            if ($temME > 0) {
                echo "<option value=\"me" . $codME . "\">ME" . $codME . "</option>";
            }
            if ($temMP > 0) {
                echo "<option value=\"mp" . $numeroMP . "\">MP" . $numeroMP . "</option>";
            }
            if ($temRev > 0) {
                echo "<option value=\"rev" . $numeroRev . "\">REV" . $numeroRev . "</option>";
            }
            ?>
        </select>
    </div>
</div>
<?php
if ($temOP || $temME) {
    //se tem só OP
    if ($temOP == 1 && $temME == 0) {
        $max = $nroPernasOP;
    } else {
        //se tem só mE
        if ($temOP == 0 && $temME == 1) {
            $max = $nroPernasME;
        } else {
            if ($nroPernasOP > $nroPernasME) {
                $max = $nroPernasOP;
            } else {
                $max = $nroPernasME;
            }
        }
    }

    echo "<div class='form-group'>" .
        "<label class='control-label col-sm-2' for='perna'>Núm. Perna: </label>" .
        "<div class='col-sm-2'>" .
        "<input class='form-control' name='perna' type='text' id='perna' min='1' max='" . $max . "'>" .
        "<div id='erroperna'></div></div>" .
        "</div>";
}
?>
<div class="form-group">
    <label class="control-label col-sm-2" for="icaoOrigem">ICAO Origem</label>
    <div class="col-sm-2">
        <input class="form-control" name="icaoOrigem" type="text" id="icaoOrigem" maxlength="4">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="icaoDestino">ICAO Destino: </label>
    <div class="col-sm-2">
        <input class="form-control" name="icaoDestino" type="text" id="icaoDestino" maxlength="4">
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#perna").focusout(function(e) {
            //^\d{2}|FE|fe$
            var input = $(this).val();
            var patt = /^\d{2}|FE|fe$/g;
            var result = patt.test(input);

            if (!result) {
                $("#erroperna").html("Erro!");
            } else {
                $("#erroperna").html("");
            }
        });
    });
</script>