
<?php 

$query_rsAeronaves = "SELECT *  FROM aeronave where status='a' order by nome";
$rsAeronaves = $con->query($query_rsAeronaves) or die(mysql_error());
$row_rsAeronaves = $rsAeronaves->fetch_assoc();
$totalRows_rsAeronaves = $rsAeronaves->num_rows;


?>

<br />
<h3>Cadastro de Aeronaves</h3>

<input name="botInserir" type="button" value="Inserir" onclick="window.open('index.php?pagina=cad/cad_aeronave&amp&cod_aeronave=0','_self')"/>
<br /><br />
<table border="1" align="center">
  <tr>
  	<th><strong>C&oacute;digo</strong></th>
    <th><strong>Nome</strong></th>
    <th><strong>Vers&atilde;o</strong></th>
	<th colspan="3" align="center"><strong>A&ccedil;&otildes</strong></th>
  </tr>
  <?php 
  	do { 
    	echo "<td align=\"center\">".$row_rsAeronaves['cod_aeronave']."</td>
      			<td align=\"center\">".$row_rsAeronaves['nome']."</td>
      			<td align=\"center\">".$row_rsAeronaves['versao']."</td>  
	  			<td><a href=\"index.php?pagina=cad/cad_aeronave&cod_aeronave=".$row_rsAeronaves['cod_aeronave']."\">&nbsp;Alterar&nbsp;</a></td><td>&nbsp;Inativar&nbsp;</td><td><a href=\"cad_manual.php?aeronave=".$row_rsAeronaves['cod_aeronave']."\" target=\"_blank\" onClick=\"window.open(this.href, this.target, \"width=600,height=700\"); return false;\">&nbsp;Manual&nbsp;</a></td>
    </tr>";
    } while ($row_rsAeronaves = $rsAeronaves->fetch_assoc()); ?>
</table>