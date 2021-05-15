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
<h3>Arquivos para Download</h3>
<br /><table align="center" border="1"><tr><th>Arquivo</th><th>Data Upload</th></tr><tr>
	<?
		$sql = "select * from downloads order by data_upload desc";
		$res = mysql_query($sql);
		
		while($row = mysql_fetch_assoc($res)){
			echo "<td><a href=\"".$dir_arquivos.$row['nome_arquivo']."\">".utf8_encode($row['dsc'])."</td><td align='center'>".ansi2br($row['data_upload'])."</td></tr>";
		}
				
	?>
</table>	
