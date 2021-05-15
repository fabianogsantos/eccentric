<script type="text/javascript">
function confirmDelete()
{
    var agree=confirm("Esta rota será apagada do banco de dados. Confirma ?");
    if (agree)
        return true;
    else
        return false;
}     
</script>

<?php 

$query_rs = "SELECT num AS num, 
   	icaoorigem ,
   	a.cidade as cidadeorigem,
   	icaodestino , 
   	c.cidade as cidadedestino,
   	nucleo,
   	posto,
	vooanterior
FROM icao a, voooficial b, icao c
WHERE a.icao = b.icaoorigem
AND c.icao= b.icaodestino
ORDER BY 1 ";
$rs = $con->query($query_rs);
$row_rs = $rs->fetch_assoc();
$totalRows_rs = $rs->num_rows;


?>

<br />
<h3>Lista de Voos Oficiais</h3>

<input name="botInserir" type="button" value="Inserir" onclick="window.open('index.php?pagina=cad/cad_rotas','_self')"/>
<br /><br />
Total de voos cadastrados: <?php echo $totalRows_rs."<br />"; ?>
<table border="1" align="center">
  <tr>
  	<th><strong>N&uacute;mero</strong></th>
    <th colspan="2"><strong>Origem</strong></th>    
    <th colspan="2"><strong>Destino</strong></th>
    <th><strong>N&uacute;cleo</strong></th>
    <th><strong>Posto</strong></th>        
	<th align="center"><strong>Ações</strong></th>
  </tr>
  <?php 
  	do { 
    	echo "<td align=\"center\">".$row_rs['num']."</td>
      			<td align=\"center\">".$row_rs['icaoorigem']."</td>
      			<td align=\"center\">".$row_rs['cidadeorigem']."</td>
      			<td align=\"center\">".$row_rs['icaodestino']."</td>  
      			<td align=\"center\">".$row_rs['cidadedestino']."</td>	
      			<td align=\"center\">".$row_rs['nucleo']."</td>					
      			<td align=\"center\">".$row_rs['posto']."</td>					
	  			<td><a href=\"index.php?pagina=apagaNoticia&numero=".$row_rs['num']."\" onclick=\"return confirmDelete();\"><img src=\"imagens/icon_del.gif\" alt=\"Apagar\" /></a></td>
    </tr>";
    } while ($row_rs = $rs->fetch_assoc()); ?>
</table>