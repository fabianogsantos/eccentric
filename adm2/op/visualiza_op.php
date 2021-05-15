<?php

$id = $_GET['id'];
$query_rsop = "SELECT * FROM op where id=$id";
$rsop = $con->query($query_rsop);
$row_rsop = $rsop->fetch_assoc();
$totalRows_rsop = $rsop->num_rows;
$piloto = $row_rsop['callsign'];

$query_rsAnv = "SELECT * FROM aeronave where status='a'";
$rsAnv = $con->query($query_rsAnv);
$row_rsAnv = $rsAnv->fetch_assoc();
$totalRows_rsAnv = $rsAnv->num_rows;

$sql_posto = "select nome_posto from posto where cod_posto = (select cod_posto from piloto where callsign = $piloto)";
$res_posto = $con->query($sql_posto);
$row_posto = $res_posto->fetch_assoc();

?>
<h3>Dados da OP</h3>
<p>Abaixo est&atilde;o as informa&ccedil;&otilde;es da OP selecionada</p><hr color="#006600" />

<form name="dados_op" action="index.php?pagina=op/efetiva_op" method="post">
  <input name="id" type="hidden" value="<?php echo $row_rsop['id']; ?>" />
  <div class="form-group">
      <label for="idop">ID</label>
      <input class="form-control" type="text" id="idop" name="idop" value="<?php echo $row_rsop['id']; ?>">
  </div>
  <div class="form-group">
    <label for="rota">Rota</label>
    <textarea class="form-control" name="escalas" cols="30" rows="5"><?php echo $row_rsop['escalas']; ?></textarea>
  </div>
  <div class="form-group">
    <label for="nropernas">Número de pernas</label>
    <input type="number" class="form-control" id="nropernas" name="nropernas" value="<?php echo $row_rsop['nropernas']; ?>">
  </div>
  <div class="form-group">
    <label for="callsign">Callsign</label>
    <input class="form-control" type="text" id="callsign" name="callsign" value="<?php echo $row_rsop['callsign']; ?>">
  </div>
  <div class="form-group">
    <label for="posto">Posto</label>
    <input class="form-control" type="text" name="posto" value="<?php echo $row_posto['nome_posto']; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="datapedido">Data do pedido</label>
    <input type="text" class="form-control" name="datapedido" id="datapedido" value="<?php echo ansi2br($row_rsop['data_pedido']); ?>">
  </div>
  <div class="form-group">
    <label for="cod_aeronave">Aeronave</label>
    <select name="cod_aeronave" id="cod_aeronave" class="form-control">
      <?php
        do {
          if ($row_rsop['cod_aeronave']==$row_rsAnv['cod_aeronave'])
            echo "<option value=\"".$row_rsAnv['cod_aeronave']."\" selected>".$row_rsAnv['nome']."</option>";
          else
            echo "<option value=\"".$row_rsAnv['cod_aeronave']."\">".$row_rsAnv['nome']."</option>";
        } while ($row_rsAnv = $rsAnv->fetch_assoc());
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="motivo">Ação</label>
    <select name="motivo" id="motivo" class="form-control">
  		<option value="a" selected>Aprovar</option>
      <option value="d">Apagar do BD</option>
  		<option value="c">Cancelar</option>
  		<option value="f">Finalizar</option>
  		<option value="1">Reprovar - Preench. incorreto solicita&ccedil;&atilde;o</option>
  		<option value="2">Reprovar - Posto do piloto n&atilde;o autorizado</option>
  		<option value="3">Reprovar - Anv. incompat. com o posto</option>
  		<option value="4">Reprovar - Anv. incompat. com algum aeroporto</option>
  		<option value="5">Reprovar - Piloto tem outra rota n&atilde;o finalizada</option>
  		<option value="6">Reprovar - Outros motivos</option>
  		</select>
  </div>
  <input class="btn btn-primary" name="butEnvia" type="submit" value="Efetivar dados" />
</form>
