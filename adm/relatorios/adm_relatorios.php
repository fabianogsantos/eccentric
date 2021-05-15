<?php
if(!isset($_SESSION["callsign"])){
	echo "<h3>Ops, sem logar n&atilde;o d&aacute;!</h3>";
	exit;
}

$sql = "select * from relatorios where status = 1";
$res = $con->query($sql);
$num = $res->num_rows;

?>
<h3>Relat&oacute;rios</h3>
<hr color="#009933"><br />
<br><br>
<?php
	if ($num>0)
	{
?>
<table id="t_relatorios" class="display table table-bordered" cellspacing="0" width="100%">
  <thead>
  <tr>
    <th>Callsign</th>
    <th>Nome</th>
    <th>N&uacute;mero</th>
    <th>Data Envio</th>
        <th>&nbsp;N&uacute;cleo&nbsp;</th>
        <th>Status</th>
    <th colspan="3">A&ccedil;&otilde;es</th>
  </tr>
</table>

<?php
}
else{
  echo "N&atilde;o existem relat&oacute;rios no momento.";
}
?>
