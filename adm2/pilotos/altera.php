<?php
$piloto = $_GET["callsign"];
$ok = empty($_GET['ok'])?false:true;

if(!$ok){
  $sql = "select * from piloto where callsign = $piloto";
  $res = $con->query($sql);
  $row = $res->fetch_assoc();

  $query_rsPaises = "SELECT * FROM pais";
  $rsPaises = $con->query($query_rsPaises);
  $row_rsPaises = $rsPaises->fetch_assoc();
  $totalRows_rsPaises = $rsPaises->num_rows;
}
else {
  $callsign 		= $_POST["callsign"];
  $nome 			= $_POST["nome"];
  $nome_guerra 	= $_POST["nome_guerra"];
  $cidade 		= $_POST["cidade"];
  $uf 			= $_POST["uf"];
  $pais 			= $_POST["pais"];
  $senha 			= $_POST["senha"];
  $email 			= $_POST["email"];
  $data_ingresso 	= br2ansi($_POST["data_ingresso"]);
  $data_nasc 		= br2ansi($_POST["data_nasc"]);
  $nucleo 		= $_POST["nucleo"];
  $status 		= $_POST["ativo"];

  //verifica se o callsign j� existe, se positivo: update, negativo: insert
  $sql2 = "select callsign from piloto where callsign = $callsign";
  $res2 = $con->query($sql2);

  if ($res2->num_rows>0){
    $sqlU="update piloto set nome='$nome',nome_guerra='$nome_guerra',cidade='$cidade',uf='$uf',cod_pais=$pais,data_ingresso='$data_ingresso',data_nasc='$data_nasc',email='$email',nucleo='$nucleo',status='$status' where callsign = $callsign";
    $resU = $con->query($sqlU);
  }
  $url = $_SERVER['PHP_SELF'].'?pagina=adm_pilotos';
  header('Location: '.$url);
}

?>

<h3>Cadastro de pilotos</h3>
<form name="frm_dados" method="post" action="<?php echo $_SERVER['PHP_SELF'].'?pagina=cad/altera_piloto&ok=s'; ?>">

<table border="0">
  <tr>
    <td><div align="right"><strong>Callsign:</strong></div></td>
    <td><input name="callsign" type="text" size="3" maxlength="3" value="<?php echo $row['callsign'];?>"></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Nome:</strong></div></td>
    <td><input name="nome" type="text" size="50" maxlength="50" value='<?php echo $row['nome'];?>'></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Nome de Guerra:</strong></div></td>
    <td><input name="nome_guerra" type="text" size="30" maxlength="30" value='<?php echo $row['nome_guerra'];?>'></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Cidade:</strong></div></td>
    <td><input name="cidade" type="text" size="50" maxlength="50" value='<?php echo $row['cidade'];?>'></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Estado:</strong></div></td>
    <td>
      <?php
	  	$estados = Array("NA","AC","AL","AM","AP","BA","CE","DF","ES","GO","MA","MG","MS","MT","PA","PB","PE","PI","PR","RJ","RN","RO","RR","RS","SC","SE","SP","TO");
		echo "<select name =\"uf\">";
      		$valor= $row['uf'];
			foreach($estados as $val_array){
	      		if ($val_array == $valor){
					echo "<option value =\"".$val_array."\" selected>".$val_array."</option>";
				}
				else {
					echo "<option value =\"".$val_array."\">".$val_array."</option>";
				}
			}
      ?>
    </td>
  </tr>
  <tr>
    <td><div align="right"><strong>Pa&iacute;s:</strong></div></td>
    <td>
      <?php
      		$codPais = $row['cod_pais'];
			echo "<select name=\"pais\" id=\"pais\">";

			do {
			   	echo "<option value=\"".$row_rsPaises['cod_pais']."\"";
				if (strcmp($row_rsPaises['cod_pais'],$codPais)==0) {echo "SELECTED";}
				echo ">".$row_rsPaises['nome']."</option>";
			} while ($row_rsPaises = $rsPaises->fetch_assoc());
	    	$rows = $rsPaises->num_rows;
		    if($rows > 0) {
				mysqli_data_seek($rsPaises, 0);
			  	$row_rsPaises = $rsPaises->fetch_assoc();
				echo  "</select>";
			}
      ?>
    </td>
  </tr>
  <tr>
    <td><div align="right"><strong>Senha:</strong></div></td>
    <td><input name="senha" type="password" size="6" maxlength="6" value='<?php echo $row['senha'];?>'></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Data ingresso:</strong></div></td>
    <td>
      <?php
   		$valor= ansi2br($row['data_ingresso']);
		echo "<input name=\"data_ingresso\" type=\"text\" size=\"10\" maxlength=\"10\" value=$valor><br>";
      ?>
    </td>
  </tr>
  <tr>
    <td><div align="right"><strong>Data Nascimento:</strong></div></td>
    <td>
      <?php
   		$valor= ansi2br($row['data_nasc']);
		echo "<input name=\"data_nasc\" type=\"text\" size=\"10\" maxlength=\"10\" value=$valor><br>";
      ?>
    </td>
  </tr>
  <tr>
    <td><div align="right"><strong>Email:</strong></div></td>
    <td><input name="email" type="text" size="50" maxlength="50" value='<?php echo $row['email']; ?>'></td>
  </tr>
  <tr>
    <td><div align="right"><strong>N&uacute;cleo:</strong></div></td>
    <td>
    <?php
		$sql = "select * from nucleo";
		$res = $con->query($sql);

		echo "<select name=\"nucleo\">";
      		$valor= $row['nucleo'];
			while ($lin = $res->fetch_array()){
				$val = $lin["sigla_nucleo"];
				if ($valor == $val){
					echo "<option value=\"".$lin["sigla_nucleo"]."\" selected>".utf8_encode($lin["nome_nucleo"])."</option>";
				}
				else{
					echo "<option value=\"".$lin["sigla_nucleo"]."\">".utf8_encode($lin["nome_nucleo"])."</option>";
				}
			}
		?>
    </select>
    </td>
  </tr>
   <tr>
    <td><div align="right"><strong>Ativo ?</strong></div></td>
    <td>
    <?php
		echo "<select name=\"ativo\">";
      		$valor= $row['status'];
			if ($valor == 'a'){
				echo "<option value=\"a\" selected>Sim</option>";
				echo "<option value=\"i\" >N&atilde;o</option>";
			}
			else{
				echo "<option value=\"a\">Sim</option>";
				echo "<option value=\"i\" selected>N&atilde;o</option>";
			}
		?>
    </select>
    </td>
  </tr>
</table>
<input type="hidden" name="acao" value="alt" />
<input type="submit" name="Submit" value="Ok" class="botao">
</form>
