<?php
	if(!isset($_SESSION["callsign"])){
		?><script language="Javascript">
				window.open("index.php?pagina=pagina&pid=10","_parent");
		</script><?php
    	exit;
	}
	require_once("conecta.php");
	$callsign = $_SESSION["callsign"];
?>
<h1 class="page-header">Lista dos Pilotos Ativos</h1>

<?php
	echo "<TABLE class=\"table table-condensed table-striped\">
			<thead>
			<tr>
			<th>Callsign</th>
	      	<th>Piloto</th>
		  	<th>Email</th></tr>
			</thead>";

	$sql = "select * from piloto where status = 'a' order by callsign";
	$res = $con->query($sql);
	while ($row = $res->fetch_assoc()){	
		echo "<TR><TD>ETR-".completazeros($row["callsign"])."</TD><TD>Cmte. ".utf8_encode($row["nome_guerra"])."</TD><TD>
		 <a href=\"mailto:".$row["email"]."\">".$row["email"]."</a></TR>";		
	}
	echo "</TABLE>";

?>