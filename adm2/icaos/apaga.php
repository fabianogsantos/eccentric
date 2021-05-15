<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		if ($_SERVER['REQUEST_METHOD']=='GET'){
            $icao = $_GET['icao'];
          
            $query = "DELETE FROM icao where icao='$icao'";
            $rs = $con->query($query);
            $url = $_SERVER['PHP_SELF']."?pagina=icaos/icaos";
            echo "<script>window.location = \"".$url."\"</script>";
        }
    }
?>