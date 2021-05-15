<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		if ($_SERVER['REQUEST_METHOD']=='GET'){
            $cod_aeronave= $_GET['cod_aeronave'];
          
            $query = "DELETE FROM aeronave where cod_aeronave='$cod_aeronave'";
            $rs = $con->query($query);
            $url = $_SERVER['PHP_SELF']."?pagina=aeronaves/aeronaves";
            echo "<script>window.location = \"".$url."\"</script>";
        }
    }
?>