<?php
	$numero = $_GET['numero'];
	
	$sql = "delete from relatorios where numero=$numero";
	$res = mysql_query($sql);
	?><script language="Javascript">
		window.open("index.php?pagina=adm_relatorios","_self");
	</script>
	<?php

?>


