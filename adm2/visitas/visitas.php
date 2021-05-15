<?php
$query = "SELECT id,DATE_FORMAT(data,'%d/%m/%Y') AS _data,nome,email,case respondido when 0 then '<span class=\'label label-danger\'>Não</span>' else '<span class=\'label label-success\'>Sim</span>' end as _respondido  FROM livro_visitas order by data desc";
$rsVisitas = $con->query($query) or die(mysql_error());
$row = $rsVisitas->fetch_assoc();

?>
<div class="page-header">
  <h3>Livro de visitas</h3>
</div>

<table class="table table-responsive table-condensed table-striped table-hover">
  <thead>
    <th>Data</th>
    <th>Nome</th>
    <th>Email</th>
    <th>Lido (S/N)</th>
  </thead>
  <?php
  	do {
    	echo "<tr>
            <td>".$row['_data']."</td>
      			<td><a href='index.php?pagina=visitas/visita&id=".$row['id']."'>".$row['nome']."</a></td>
      			<td>".$row['email']."</td>
            <td>".$row['_respondido']."</td>
            </tr>";
    } while ($row = $rsVisitas->fetch_assoc()); ?>
</table>
