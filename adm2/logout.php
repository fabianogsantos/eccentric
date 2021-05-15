<?php
session_start();

$_SESSION['callsign'] = NULL;  
unset($_SESSION['callsign']);
session_destroy();
?><script language="Javascript">
	window.open("index.php?pagina=inicio","_parent");
</script>