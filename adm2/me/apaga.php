<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		if ($_SERVER['REQUEST_METHOD']=='GET'){
            $cod = $_GET['cod'];
          
            $query = "DELETE FROM me where cod='$cod'";
            $rs = $con->query($query);
            $url = $_SERVER['PHP_SELF']."?pagina=me/mes";
            echo "<script>window.location = \"".$url."\"</script>";
        }
    }
?>