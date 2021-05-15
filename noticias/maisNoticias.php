 <script language ="JavaScript">
function filtro(what) {
   if (what.selectedIndex != '') {
      var opcao = what.value;
      document.location=('index.php?pagina=maisNoticias&data=' + opcao);
   }
}
</script>
<?php
	$data = $_GET['data'];

	if (!isset($data)){
		$query  = "SELECT *
				FROM noticia
				WHERE num_noticia = (SELECT MAX(num_noticia) FROM noticia)";
		$result = $con->query($query);
	}
	else {
		$query  = "SELECT *
				FROM noticia
				WHERE data_noticia = '$data'";
		$result = $con->query($query);
	}

	$sqlo = "select distinct data_noticia from noticia order by data_noticia desc";
	$reso = $con->query($sqlo);

	echo "<h3>Not&iacute;cias da Companhia</h3><br>";
	echo "<p>Filtre pela data:&nbsp;";
	echo "<select onChange=\"filtro(this);\">";
	while ($rowo = $reso->fetch_assoc()){
		if ($rowo['data_noticia']==$data)
			$sel=' selected ';
		else
			$sel='';
		echo "<option ".$sel."value=\"".$rowo['data_noticia']."\">".ansi2br($rowo['data_noticia'])."</option>";
	}
	echo "</select></p>";

	$row =$result->fetch_assoc();

	echo "<br><hr>";
	echo $row['txt_noticia'];
?>
