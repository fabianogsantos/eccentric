<?
	$sql = "select * from noticia order by data_noticia desc";
	$res = mysql_query($sql);	
?>
<h3>Cadastro de Notícias</h3>
 <p><input name="Inserir" type="button" onclick="window.open('index.php?pagina=cad_noticia&amp&acao=ins','_self')" value="Inserir" />
<table border="1">
	<thead>
	  <tr> 
	    <th>Data</th>
    	<th>Notícia</th>
    	<th>Ações</th>
	  </tr>
	</thead>	  
  <?
	while ($row = mysql_fetch_assoc($res)){
		echo "<tr><td>".ansi2br($row["data_noticia"])."</td>
		<td>".rtrim($row["txt_noticia"],50)."</td>
		<td><a href=\"index.php?pagina=man_noticia&num_noticia=".$row["num_noticia"]."&acao=del\">Apagar</a></td>";
	}
  ?>
</table>
