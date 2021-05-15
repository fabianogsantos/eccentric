
<?php 

$query_rsPais = "SELECT *  FROM pais order by nome";
$rsPais = $con->query($query_rsPais) ;
$row_rsPais = $rsPais->fetch_assoc();
$totalRows_rsPais = $rsPais->num_rows;


?>

<br />
<h3>Cadastro de Países</h3>

<table border="1" align="center">
  <tr>
  	<th><strong>Código</strong></th>
    <th><strong>Nome</strong></th>
    <th><strong>Arquivo</strong></th>
	<th colspan="3" align="center"><strong>Ações</strong></th>
  </tr>
  <?php 
  	do { 
    	echo "<td align=\"center\">".$row_rsPais['cod_pais']."</td>
      			<td align=\"center\">".$row_rsPais['nome']."</td>
      			<td align=\"center\">".$row_rsPais['imagem']."</td>  
	  			<td><a href=\"index.php?pagina=cad/cadPais&cod=".$row_rsPais['cod_pais']."\">&nbsp;Alterar&nbsp;</a></td>
    </tr>";
    } while ($row_rsPais = $rsPais->fetch_assoc()); ?>
</table>