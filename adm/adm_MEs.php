<?php 
$query = "SELECT *  FROM me";
$rs = $con->query($query);
$row = $rs->fetch_assoc();
$totalRows = $rs->num_rows;


?>

<br />
<h3>Cadastro de Missões Especiais</h3>

<input name="botInserir" type="button" value="Inserir" onclick="window.open('index.php?pagina=cad/cad_ME&cod=0','_self')"/>
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
    	echo "<td align=\"center\">".$row['cod']."</td>
      			<td align=\"center\">".$row['nome']."</td>
      			<td align='center'><img src='../".$dir_imagem_me.$row['imagem']."' width='195' /></td>  
	  			<td><a href=\"index.php?pagina=cad/cad_ME&cod=".$row['cod']."\"><img src=\"imagens/icon_edit.gif\" width=\"15\" height=\"15\" alt=\"Alterar\"/></a></td>
				<td><a href=\"index.php?pagina=cad/cad_ME&cod=".$row['cod'].'&acao=del'."\"><img src=\"imagens/icon_del.gif\" width=\"15\" height=\"15\" alt=\"Remover\"/></a></td>";
		if ($row['status']==0)
			echo "<td><a href=\"index.php?pagina=cad/cad_ME&cod=".$row['cod'].'&acao=ati'."\"><img src=\"imagens/12.png\" width=\"15\" height=\"15\" alt=\"Inativa\"/></a></td></tr>";
		else
			echo "<td><a href=\"index.php?pagina=cad/cad_ME&cod=".$row['cod'].'&acao=ina'."\"><img src=\"imagens/10.png\" width=\"15\" height=\"15\" alt=\"Ativa\"/></a></td></tr>";
    } while ($row = $rs->fetch_assoc()); ?>
</table>
