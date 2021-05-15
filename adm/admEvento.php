
<?php 

$query = "SELECT *  FROM me";
$rs = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($rs);
$totalRows = mysql_num_rows($rs);


?>

<br />
<h3>Cadastro de Missões Especiais</h3>

<input name="botInserir" type="button" value="Inserir" onclick="window.open('index.php?pagina=cad_ME&cod_me=0','_self')"/>
<br /><br />
<table border="1" align="center">
  <tr>
  	<th><strong>Código</strong></th>
    <th><strong>Nome</strong></th>
    <th><strong>Imagem Reduzida</strong></th>
	<th colspan="3" align="center"><strong>Ações</strong></th>
  </tr>
  <?php 
  	do { 
    	echo "<td align=\"center\">".$row['cod_me']."</td>
      			<td align=\"center\">".$row['des_me']."</td>
      			<td align=\"center\"><img src=\"".$dir_imagem_me.$row['imagem']."\" width=\"195\" /></td>  
	  			<td><a href=\"index.php?pagina=cad_me&cod_me=".$row['cod_me']."\">&nbsp;Alterar&nbsp;</a></td><td>Remover</td></tr>";
    } while ($row = mysql_fetch_assoc($rs)); ?>
</table>