
<?php
$query = "SELECT *  FROM mp";
$rs = $con->query($query);
$row = $rs->fetch_assoc();
$totalRows = $rs->num_rows;
?>

<br />
<h3>Cadastro de Voos Multiplayer</h3>

<input name="botInserir" type="button" value="Inserir" onclick="window.open('index.php?pagina=cad/cad_MP&cod_mp=0','_self')"/>
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
      			<td align=\"center\"><img src=\"..\\".$dir_imagem_mp.$row['imagem']."\" width=\"195\" /></td>
	  			<td><a href=\"index.php?pagina=cad/cad_MP&cod_mp=".$row['cod']."\"><img src=\"imagens/icon_edit.gif\" width=\"15\" height=\"15\" alt=\"Alterar\"/></a></td>
				<td><img src=\"imagens/icon_del.gif\" width=\"15\" height=\"15\" alt=\"Remover\"/></td>";
		if ($row['status']==0)
			echo "<td><img src=\"imagens/icones/12.png\" width=\"15\" height=\"15\" alt=\"Inativa\"/></td></tr>";
		else
			echo "<td><img src=\"imagens/icones/10.png\" width=\"15\" height=\"15\" alt=\"Ativa\"/></td></tr>";
    } while ($row = $rs->fetch_assoc()); ?>
</table>
