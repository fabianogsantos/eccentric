<?php
if (!isset($_SESSION["callsign"])) {
    echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $num = $_GET['num'];

        $query = "DELETE FROM voooficial where num='" . $num . "'";
        $rs = $con->query($query);
        $url = $_SERVER['PHP_SELF'] . "?pagina=voos/voos";
        echo "<script>window.location = \"" . $url . "\"</script>";
    }
}
