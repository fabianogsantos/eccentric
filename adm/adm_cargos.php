<?php 
require_once('../Connections/con1.php'); 
mysql_select_db($database_con1, $con1);
$query_rsCargos = "SELECT * FROM cargo";
$rsCargos = mysql_query($query_rsCargos, $con1) or die(mysql_error());
$row_rsCargos = mysql_fetch_assoc($rsCargos);
$totalRows_rsCargos = mysql_num_rows($rsCargos);

//mysql_free_result($rsCargos);
?>
<h2 align="center">Cadastro de cargos</h2>
<input name="Inserir" type="button" onclick="window.open('index.php?pagina=ins_cargo','_parent')" value="Inserir" />
<table class="bordasimples" align="center">
  <tr>
    <td><strong>Código</strong></td>
    <td><strong>Descrição</strong></td>
    <td><strong>Email para o cargo</strong></td>
	<td colspan="2" align="center"></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsCargos['cod_cargo']; ?></td>
      <td><?php echo $row_rsCargos['des_cargo']; ?></td>
      <td><?php echo $row_rsCargos['email_cargo']; ?></td>
	  <td><a href="../index.php?pagina=cad_cargos&amp;cod_cargo=<?php echo $row_rsCargos['cod_cargo']; ?>"><img src="../imagens/icon_edit.gif" alt="Alterar" width="16" height="16" border="0"/></a><img src="../imagens/icon_del.gif" width="16" height="16" /></td>
    </tr>
    <?php } while ($row_rsCargos = mysql_fetch_assoc($rsCargos)); ?>
</table>
