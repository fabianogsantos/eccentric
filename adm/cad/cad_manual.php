<?php
include_once("../fckeditor/fckeditor.php") ;
include("../funcoes.php");
include("../conecta.php");
$anv = $_GET['aeronave'];

$sql = "select nome from aeronave where cod_aeronave = $anv";
$res = mysql_query($sql);
$row = mysql_fetch_assoc($res);
$nome = $row['nome'];

$sql = "select txt_manual from manual where cod_aeronave = $anv";
$res = mysql_query($sql);
$row = mysql_fetch_assoc($res);

echo "<h3>Manual da Aeronave - ".$nome."</h3>";

?>
<br />Use o editor de texto abaixo para editar o manual da aeronave. Clique em enviar para salvar as alterações.<br /><br />
<form action="../insereTextoManual.php" method="post" target="_blank">
<?php
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = 'fckeditor/' ;
$oFCKeditor->Value = utf8_encode($row['txt_manual']) ;
$oFCKeditor->Create() ;
?>
    <br>
    <input type="hidden" name="anv" value="<? echo $anv; ?>" />
  </form>
