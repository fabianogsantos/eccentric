<?php
session_start();
    include 'configura.php';
    include 'conecta.php';
    include 'funcoes.php';

    if(isset($_SESSION["callsign"])){
        $callsign = $_SESSION["callsign"];
        $sql = "select * from piloto where callsign=$callsign and status='a'";
        $res = $con->query($sql);
        $row = $res->fetch_assoc();

        $tipo_piloto = $row["tipo_piloto"];
        $_SESSION['tipo_piloto'] = $tipo_piloto;
        $nome_guerra = $row["nome_guerra"];
        $nucleo      = $row["nucleo"];
        $ultimo_login = $row["ultimo_login"];

        $sql = "select * from dossie_piloto where callsign = $callsign";
        $res = $con->query($sql);
        $row = $res->fetch_assoc();
        $ultima_alt_dossie = ansi2br($row["ultima_alt_dossie"]);
        $dataUltimoVoo = ansi2br($row["data_ult_voo"]);
    }

    $pagina="inicio";
    if(isset($_GET["pagina"]))
        $pagina=$_GET["pagina"];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Uma das mais antigas companhias aéreas virtuais do país">
    <meta name="author" content="Fabiano Gonçalves dos Santos">

    <title>Eccentric Travels</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/small-business.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="include/bootstraptable/bootstrap-table.css">

    <style>
        .naomostra {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            height: 0;
            width: 0;
            z-index: -1;
        }
    </style>

    <script src="js/jquery.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="js/validate/dist/jquery.validate.min.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <?php
            if ($pagina == "inicio"){
                include 'inicio.php';
            }
            else{
                $url = $pagina.'.php';
                include "$url";
            }
        ?>
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Eccentric Travels 2021</p>
                </div>
            </div>
        </footer>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="include/bootstraptable/bootstrap-table.js"></script>
    <script src="include/bootstraptable/locale/bootstrap-table-pt-BR.js"></script>
</body>
</html>
