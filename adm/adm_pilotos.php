<?php
	$opcao = empty($_GET['opcao'])?'':$_GET["opcao"];
	if ($opcao =="a"){
		$sql = "select callsign, nome_guerra, status from piloto where status = 'a' order by callsign ";
		$res = $con->query($sql);
	}
	elseif ($opcao =="i"){
		$sql = "select callsign, nome_guerra, status from piloto where status = 'i' order by callsign";
		$res = $con->query($sql);
	}
	else {
		$sql = "select callsign, nome_guerra, status from piloto where status ='a' order by callsign";
		$res = $con->query($sql);
	}

	$sql_num_at = "select count(callsign) as qtd from piloto where status = 'a'";
	$res_at = $con->query($sql_num_at);
	$num_at = $res_at->fetch_assoc()['qtd'];

	$sql_num_inat = "select count(callsign) as qtd from piloto where status = 'i'";
	$res_inat = $con->query($sql_num_inat);
	$num_inat = $res_inat->fetch_assoc()['qtd'];

?>
 <script language ="JavaScript">
function filtraPilotos(what) {
   if (what.selectedIndex != '') {
      var opcao = what.value;
      document.location=('index.php?pagina=adm_pilotos&opcao=' + opcao);
   }
}
</script>
<?php
	echo "<br><h3>Cadastro de Pilotos</h3>";
	echo "<br>Ativos: ".$num_at;
	echo "&nbsp;&nbsp;&nbsp;Inativos: ".$num_inat."";
?>

  <label>Mostrar
  <select name="select" onChange="filtraPilotos(this);">
  	<option value="">Filtre aqui</option>
    <option value="a" name="filtro_piloto">S&oacute; ativos</option>
    <option value="i" name="filtro_piloto">S&oacute; Inativos</option>
    <option value="t" name="filtro_piloto">Ativos e inativos</option>
  </select>
  </label>
  <br /><br />
  <table border="1" align="center">
  <tr>
    <th >Callsign</th>
    <th >Nome de Guerra</th>
	<th colspan="4" >A&ccedil;&otilde;es</th>
  </tr>
  <?php
	while ($row = $res->fetch_assoc()){
		$status = $row["status"];

		if ($status == 'a'){
			echo "<tr><td>".completazeros($row["callsign"])."</td>
			<td>".utf8_encode($row["nome_guerra"])."</td>
			<td><a href=\"index.php?pagina=dossie_piloto&callsign=".$row["callsign"]."\">&nbsp;Alt. Dossi&ecirc;&nbsp;</a></td><td><a href=\"..\index.php?pagina=dossie&piloto_callsign=".$row["callsign"]."\" target=\"_blank\">&nbsp;Ver dossi&ecirc;&nbsp;</a></td><td><a href=\"index.php?pagina=cad/altera_piloto&callsign=".$row["callsign"]."\">&nbsp;Alt. dados&nbsp;</a></td></tr>";		
		}
		else {
			echo "<tr><td>".$row["callsign"]."</font></td>
			<td>".utf8_encode($row["nome_guerra"])."</td>
			<td><a href=\"index.php?pagina=dossie_piloto&callsign=".$row["callsign"]."\">&nbsp;Alt. Dossi&ecirc;&nbsp;</a></td><td><a href=\"..\index.php?pagina=dossie&piloto_callsign=".$row["callsign"]."\" target=\"_blank\">&nbsp;Ver dossi&ecirc;&nbsp;</a></td><td><a href=\"index.php?pagina=cad/cad_piloto&callsign=".$row["callsign"]."&acao=alt\">&nbsp;Alt. dados&nbsp;</a></td></tr>";
		}
	}
  ?>
</table>
