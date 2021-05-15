<style type="text/css">
<!--
.atencao {
	color: #CC0000;
	font-weight:bold;}
-->
</style>
<?php

	$anv = $_GET['cod_aeronave'];
	session_start();
	if(!isset($_SESSION["callsign"])){
		?><script language="Javascript">
				window.open("index.php?pagina=pagina&pid=10","_parent");
		</script><?
    	exit;
	}
	require_once("conecta.php");
	$piloto_callsign = $_SESSION["callsign"];
	
	$sql = "select * from aeronave where cod_aeronave = $anv";
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);

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
$config["diretorio"] = "imagens/aeronaves/";

if($arquivo)
{
    $erro = array();
    
    // Verifica o mime-type do arquivo para ver se é de imagem.
    // Caso fosse verificar a extensão do nome de arquivo, o código deveria ser:
    //
    // if(!eregi("\.(jpg|jpeg|bmp|gif|png){1}$", $arquivo["name"])) {
    //      $erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo"; }
    //
    // Mas, o que ocorre é que alguns usuários mal-intencionados, podem pegar um vírus .exe e simplesmente mudar a extensão
    // para alguma das imagens e enviar. Então, não adiantaria em nada verificar a extensão do nome do arquivo.
    if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
    {
        $erro[] = "Arquivo em formato inválido! O arquivo deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
    }
    else
    {
        // Verifica tamanho do arquivo
        if($arquivo["size"] > $config["tamanho"])
        {
            $erro[] = "Arquivo em tamanho muito grande! O arquivo deve ter no máximo " . $config["tamanho"] . " bytes. Envie outro arquivo";
        }
    }

    if(!sizeof($erro))
    {
        // Pega extensão do arquivo, o indice 1 do array conterá a extensão
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
        
        // Gera nome único para a imagem
        $imagem_nome = $piloto_callsign.".".$ext[1];

        // Caminho de onde a imagem ficará
        $imagem_dir = $config["diretorio"] . $imagem_nome;

        // Faz o upload da imagem
        move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
    }
}
?>
<h3>Envio de imagem de aeronave</h3>
<p>&nbsp;</p>
<?php
// Imagem foi enviada com sucesso, mostra mensagem de SUCESSO
if($arquivo && !sizeof($erro))
{
	$desc = $_POST['desc'];
	
    echo "Seu arquivo foi enviado com sucesso!";
	$sql = "insert into downloads (dsc,nome_arquivo,callsign,data_upload,status) values ";
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
      <td>&nbsp;</td>
      <td><input type="submit" value="Enviar" /></td>
    </tr>
  </table>
</form>
<?php } ?>