<style type="text/css">
<!--
.atencao {
	color: #CC0000;
	font-weight:bold;}
-->
</style>
<?php


	session_start();
	if(!isset($_SESSION["callsign"])){
		?><script language="Javascript">
				window.open("index.php?pagina=pagina&pid=10","_parent");
		</script><?
    	exit;
	}
	require_once("conecta.php");
	$piloto_callsign = $_SESSION["callsign"];

/**
* Upload de Imagens com Segurança
*
* @author Alfred Reinold Baudisch
* @email alfred_baudisch@hotmail.com
* @date Jan 09, 2004
* @changes Jan 14, 2004 - v2.0
*/
// Prepara a variável caso o formulário tenha sido postado
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;

$config = array();
// Tamano máximo da imagem, em bytes
$config["tamanho"] = 106883;
// Diretório onde a imagem será salva
$config["diretorio"] = "arquivos/";

if($arquivo)
{
    $erro = array();

    if(!sizeof($erro))
    {      
        $nomeArquivo = $arquivo["name"].$ext[1];

        // Caminho de onde a imagem ficará
        $pasta = $config["diretorio"] . $nomeArquivo;

        // Faz o upload da imagem
        move_uploaded_file($arquivo["tmp_name"], $pasta);
    }
}
?>
<h3>Envio de novo arquivo</h3>
<br />
<p align="justify">Esta seção do site é exclusiva dos membros administradores do site. Antes de enviar o arquivo, certifique-se que o mesmo não esteja com algum vírus.</p>
<br />
<hr color="#009900" />
<?php
if($arquivo && !sizeof($erro))
{
	$desc = $_POST['desc'];
	$nomeArq = $_POST['arquivo'];
	$hoje = Date("Y-m-d");
	$status = $_POST['status'];
    echo "Seu arquivo foi enviado com sucesso!<br />";
	$sql = "insert into downloads (dsc,nome_arquivo,callsign,data_upload,status) values ('$desc','$nomeArquivo',$piloto_callsign,'$hoje','$status')";
	$Result1 = mysql_query($sql) or die(mysql_error());	
}

// Ocorreu algum erro ou ainda o formulário não foi postado
else
{
?>
<form action="<?php echo $_SERVER['$PHP_SELF']?>" method=post  ENCTYPE="multipart/form-data">
  <p>
    <?php
if(sizeof($erro))
{
    echo "<span class=\"atencao\">Ocorreu(am) o(s) seguinte(s) erro(s):<BR>";
    foreach($erro as $err)
    {
        echo " - " . $err . "<BR>";
    }
	echo "</span>";
}
?>
  </p>
  <table>
    <tr>
      <td><div align="right"><strong>Arquivo: </strong></div></td>
      <td><input type="file" size="30" name="arquivo" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Descrição:</strong></div></td>
      <td><label>
        <input name="desc" type="text" id="desc" size="50" maxlength="200" />
      </label></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Tipo:</strong></div></td>
      <td><label>
        <select name="status" id="status">
          <option value="1">Imagem ME</option>
          <option value="0">Outro</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" value="Enviar" /></td>
    </tr>
  </table>
</form>
<?php } ?>