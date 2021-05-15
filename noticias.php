<?php
$sql = "SELECT *
		FROM noticia
		WHERE id = (SELECT MAX(id) FROM noticia)";
$res = $con->query($sql);
$row = $res->fetch_assoc();
?>

<div class="panel panel-primary">
	<div class="panel-heading">Notícias da companhia</div>
	<div class="panel-body">
<?php
$data = utf8_encode($row["data"]);
echo "<p><span class=\"glyphicon glyphicon-time\"></span> ".ansi2br($data)."</p>";
echo $row["texto"];
echo "<p><a href=\"index.php?pagina=noticias/noticias\" class=\"btn btn-primary\">Mais Not&iacute;cias</a></p>";
?>
	</div>
</div>

