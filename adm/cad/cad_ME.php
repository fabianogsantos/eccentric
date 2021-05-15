<?php

$cod = empty($_GET['cod'])?0:$_GET['cod'];

if ($_SERVER['REQUEST_METHOD']=='POST') {
    include '../conecta.php';
    $cod = $_POST['cod'];
    $nome = $_POST['nome'];
    $status = $_POST['status'];
    $imagem = $_POST['imagem'];

	if ($cod!=0){
	  $SQL = "UPDATE me SET nome='$nome', imagem='$imagem', status='$status' WHERE cod=$cod";
	}
	else {
		if (empty($_POST['imagem'])){
            $imagem = 'me0.jpg';
        }
		else {
            $imagem = $_POST['imagem'];
        }

		$SQL = "insert into me (nome, imagem, status) values('$nome','$imagem','$status')";
	}
  $Result1 = $con->query($SQL);
    $redirect = "index.php?pagina=adm_Mes";
    header("location:$redirect");
}
else {
    $query = "SELECT * FROM me where cod=$cod";
    $rs = $con->query($query);
    $row = $rs->fetch_assoc();
}

?>
<h3>Cadastro de Miss&atilde;o Especial</h3>
<br />
<form method="post" name="form1" action="<?php echo $_SERVER['PHP_SELF']."?pagina=cad/cad_ME"; ?>">
  <table align="center">
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>C&oacute;digo:</strong></td>
      <?php
	  	if ($cod==0){
            include '../conecta.php';
            $sql1 = "select max(cod) as maxi from me";
            $rs = $con->query($sql1);
            $row=$rs->fetch_assoc();
            $novoCodigo = $row['maxi'];
            $cod = $novoCodigo+1;
        }
		else{
            $cod = $row['cod'];
        }
        echo "<td><input type=\"text\" name=\"cod\" value=\"".$cod."\" size=\"60\"></td>";
	   ?>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Nome:</strong></td>
      <td><input type="text" name="nome" value="<?php echo $row['nome']; ?>" size="60"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Imagem:</strong></td>
      <?php
	  	if ($cod==0){
            echo "<td><input name=\"imagem\" type=\"text\" /><a href=\"index.php?pagina=formEnviaArquivo\">Clique aqui para enviar uma imagem</a></td>";
        }
		else {
            echo "<td><input name='imagem' type='text' readonly='true' value='".$row['imagem']."'/><br/>
<a href=\"index.php?pagina=formEnviaArquivo\"><img src='../".$dir_imagem_me.$row['imagem']."' width=\"410\"/></a><br/>Clique na imagem acima para alterar. Não é possível alterar pelo nome.</td>";
        }

	  ?>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>Status:</strong></td>
      <td><select name="status">
        <option value="1" <?php if (!(strcmp("1", $row['status']))) {echo "SELECTED";} ?>>Ativa</option>
        <option value="0" <?php if (!(strcmp("0", $row['status']))) {echo "SELECTED";} ?>>Inativa</option>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap><strong>N&ugrave;mero de pernas:</strong></td>
      <td><input type="text" name="nropernas" value="<?php echo $row['nropernas']; ?>" size="2"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="Submit" type="submit" value="Gravar!"></td>
    </tr>
  </table>
</form>