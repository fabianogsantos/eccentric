<?
	session_start();
	if(!isset($_SESSION["callsign"])){
		?><script language="Javascript">
				window.open("index.php?pagina=pagina&pid=10","_parent");
		</script><?
    	exit;
	}
	$callsign = $_SESSION["callsign"];
?>
<h3 align="center">Download de cartas aéreas</h3>
<ul>
	<li><a href="index.php?pagina=cartas_nacionais">Nacionais</a></li>
	<li>Internacionais</li>
	<li><a href="index.php?pagina=form_carta">Formul&aacute;rio para envio de novas cartas</a> </li>
</ul>	
		