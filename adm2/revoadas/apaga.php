<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		if ($_SERVER['REQUEST_METHOD']=='GET'){
            $cod_pais = $_GET['cod_pais'];
          
            $query = "DELETE FROM pais where cod_pais='$cod_pais'";
            $rs = $con->query($query);
            $url = $_SERVER['PHP_SELF']."?pagina=paises/paises";
            echo "<script>window.location = \"".$url."\"</script>";
        }
    }
?>