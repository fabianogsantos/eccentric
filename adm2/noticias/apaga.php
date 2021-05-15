<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		if ($_SERVER['REQUEST_METHOD']=='GET'){
            $id = $_GET['id'];
          
            $query = "DELETE FROM noticia where id='$id'";
            $rs = $con->query($query);
            $url = $_SERVER['PHP_SELF']."?pagina=noticias/noticias";
            echo "<script>window.location = \"".$url."\"</script>";
        }
    }
?>