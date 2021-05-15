<?php
if (!isset($_SESSION["callsign"])) {
  echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
} else {
  $callsign = $_SESSION['callsign'];
  $link =  "op/lista_ops.php?callsign=" . $callsign;
?>

  <h3 class="page-header">Minhas OPs <small>Consulte as suas ordens de operação na tabela abaixo</small></h3>
  <p>Segundo o Regulamento Geral, no §2º Art.53 - Para o envio de nova “Solicitação de OP” aguardar a finalização de OP anterior.</p>
  <a class="btn btn-primary" href="index.php?pagina=op/novaOp" role="button">Clique aqui para solicitar uma nova OP</a>
  <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-url="<?= $link ?>">
    <thead>
      <th data-field="num_op" data-sortable="true">Número</th>
      <th data-field="escalas">Escalas</th>
      <th data-field="aeronave" data-sortable="true">Aeronave</th>
      <th data-field="status">Status</th>
      <th data-field="data_pedido" data-sortable="true">Data Pedido</th>
    </thead>
  </table>
<?php } ?>