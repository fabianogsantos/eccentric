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
$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;

$config = array();
// Tamano máximo da imagem, em bytes
$config["tamanho"] = 500000;
// Largura Máxima, em pixels
$config["largura"] = 250;
// Altura Máxima, em pixels
$config["altura"] = 350;
// Diretório onde a imagem será salva
$config["diretorio"] = "imagens/pilotos/";

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
        $erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
    }
    else
    {
        // Verifica tamanho do arquivo
        if($arquivo["size"] > $config["tamanho"])
        {
            $erro[] = "Arquivo em tamanho muito grande! A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. Envie outro arquivo";
        }
        
        // Para verificar as dimensões da imagem
        $tamanhos = getimagesize($arquivo["tmp_name"]);
        
        // Verifica largura
        if($tamanhos[0] > $config["largura"])
        {
            $erro[] = "Largura da imagem não deve ultrapassar " . $config["largura"] . " pixels";
        }

        // Verifica altura
        if($tamanhos[1] > $config["altura"])
        {
            $erro[] = "Altura da imagem não deve ultrapassar " . $config["altura"] . " pixels";
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
<h3>Envio de foto</h3>
<?php
// Imagem foi enviada com sucesso, mostra mensagem de SUCESSO
if($arquivo && !sizeof($erro))
{
    echo "Sua foto foi enviada com sucesso!";
	$sql = "update piloto set imagem = '$imagem_nome' where callsign = $piloto_callsign";
	$Result1 = mysql_query($sql) or die(mysql_error());	
}

// Ocorreu algum erro ou ainda o formulário não foi postado
else
{
?>
<form action="<?php echo $_SERVER['$PHP_SELF']?>" method=post  ENCTYPE="multipart/form-data">
<p align="justify">Algumas instruções:<BR>
1. O arquivo a ser enviado deve possuir a extensão jpg, png, gif ou bmp.<br />
2. Por questões de espaço em nosso servidor, mande um arquivo com tamanho máximo de <?echo $config["tamanho"] ?> bytes.<br />
3. Pra poder ser melhor encaixada no seu dossiê, a imagem deve ter <? echo $config["largura"] . " pixels de largura e " . $config["altura"] ?> pixels de altura. <br />
Caso você não consiga providenciar um arquivo nestas condições, entre em contato conosco. Como sugestão, use um software de edição de imagens para adequar a sua foto nestas condições.</p>

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
<br /><p>Arquivo a ser enviado (clique no botão para procurar): <input type=file size=30 name=foto></p>
<br /><input type=submit value="Enviar">
</form>
<?php } ?>