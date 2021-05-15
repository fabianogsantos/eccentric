<?php
	$numero = $_GET['numero'];
	
	$sql = "delete from noticia where num_noticia=$numero";
	$res = mysql_query($sql);
	?><script language="Javascript">
		alert("Notícia apagada forever!");
		window.open("index.php?pagina=adm_noticias","_self");
	</script>
	<?

?>