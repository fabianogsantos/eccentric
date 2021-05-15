<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$query_rsNucleo = "SELECT sigla_nucleo, nome_nucleo FROM nucleo";
$rsNucleo = $con->query($query_rsNucleo) or die(mysql_error());
$row_rsNucleo = $rsNucleo->fetch_assoc();
$totalRows_rsNucleo = $rsNucleo->num_rows;

$num_candidato = $_GET['num_candidato'];
$query_rsCandidato = "SELECT * FROM candidato where num_candidato=$num_candidato";
$rsCandidato = $con->query($query_rsCandidato);
$row_rsCandidato = $rsCandidato->fetch_assoc();
$totalRows_rsCandidato = $rsCandidato->num_rows;

$query_rsNucleo = "SELECT * FROM nucleo";
$rsNucleo = $con->query($query_rsNucleo) ;
$row_rsNucleo = $rsNucleo->fetch_assoc();
$totalRows_rsNucleo = $rsNucleo->num_rows;

$query_rsPaises = "select p.nome from pais p,candidato c where p.cod_pais=c.pais and num_candidato=$num_candidato";
$rsPaises = $con->query($query_rsPaises);
$row_rsPaises = $rsPaises->fetch_assoc();
$totalRows_rsPaises = $rsPaises->num_rows;

?>

<h3>Dados do candidato</h3>
<form name="dados_candidato" action="index.php?pagina=efetiva_candidato" method="post">
  <table align="center">
    <tr valign="baseline">
      <td width="193" align="right" nowrap style="font-weight: bold">Código:</td>
      <td colspan="3"><?php echo $row_rsCandidato['num_candidato']; ?></td>
    </tr>
    <tr valign="baseline">
      <td width="193" align="right" nowrap style="font-weight: bold">Nome de guerra:</td>
      <td colspan="3"><input type="text" name="nome_guerra" value="<?php echo $row_rsCandidato['nome_guerra']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Nome completo: </td>
      <td colspan="3"><?php echo $row_rsCandidato['nome']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Data de nascimento:</td>
      <td colspan="3"><?php echo ansi2br($row_rsCandidato['data_nasc']); ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Cidade:</td>
      <td width="192"><?php echo $row_rsCandidato['cidade']; ?></td>
      <!--<td nowrap="nowrap"><em><strong>Pais:
      </strong></em>
      <input type="text" name="pais" value="Brasil" size="20"></td>-->
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Estado:</td>
      <td colspan="3"><?php echo $row_rsCandidato['uf']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Pa&iacute;s:</td>
      <td colspan="3"><?php echo $row_rsPaises['nome']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Telefone residencial:</td>
      <td colspan="3"><?php echo $row_rsCandidato['tel_res']; ?></td>
    </tr>
      <td nowrap align="right" style="font-weight: bold">Telefone celular:</td>
      <td colspan="3"><?php echo $row_rsCandidato['tel_cel']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Profissão:</td>
      <td colspan="3"><?php echo $row_rsCandidato['profissao']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Email:</td>
      <td colspan="3"><?php echo $row_rsCandidato['email']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Email secundário:</td>
      <td colspan="3"><?php echo $row_rsCandidato['email2']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Núcleo de operações:</td>
      <td colspan="3"><select name="nucleo">
      <?php
		$nuc = $row_rsCandidato['nucleo'];
		$sql = "select nome_nucleo from nucleo where sigla_nucleo='$nuc'";
		$res = $con->query($sql);
		$row = $res->fetch_assoc();
	  	do {
			$siglaNuc = $row_rsNucleo['sigla_nucleo'];
	  	?>
      		<option value="<?php echo $siglaNuc ?>" <?php if(!(strcmp($siglaNuc,$nuc))) {echo "SELECTED";} ?>><?php echo utf8_encode($row_rsNucleo['nome_nucleo'])?></option>
      	<?php
      } while ($row_rsNucleo = $rsNucleo->fetch_assoc());
	    $rows = $rsNucleo->num_rows;
		if($rows > 0) {
			$rsNucleo->data_seek(0);
			$row_rsNucleo = $rsNucleo->fetch_assoc();
		}
		?>
        </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap style="font-weight: bold">Versão do Flight Simulator        :</td>
      <td><?php echo $row_rsCandidato['versao_fs'];?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Realiza vôos online?</td>
      <td><?php echo trataVooOnline($row_rsCandidato['voos_online']);?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Pid (Vatsim):</td>
      <td><?php echo $row_rsCandidato['pid']; ?></td>
      <td nowrap id="dest">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Vid (IVAO):</td>
      <td><?php echo $row_rsCandidato['vid']; ?></td>
      <td nowrap id="dest">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Tipo de conexão:</td>
      <?php $tipoCon = $row_rsCandidato['internet']; ?>
      <td colspan="3"><select name="internet">
          <option value="d" <?php if (!(strcmp("d", $tipoCon))) {echo "SELECTED";} ?>>Discada</option>
          <option value="b" <?php if (!(strcmp("b", $tipoCon))) {echo "SELECTED";} ?>>Banda Larga</option>
        </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Cpf:</td>
      <td colspan="3"><?php echo $row_rsCandidato['cpf']; ?> &nbsp;&nbsp;Rg: <?php echo $row_rsCandidato['rg']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" style="font-weight: bold">Experiência:</td>
      <td colspan="3"><?php echo $row_rsCandidato['experiencia']; ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap style="font-weight: bold">Motivo pelo qual deseja<br>
        se inscrever na Eccentric:</td>
      <td colspan="3"><textarea name="motivo" cols="35" rows="5"><?php echo $row_rsCandidato['motivo']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top"  style="font-weight: bold">Ação:</td>
      <td colspan="3"><label>
        <select name="acao" id="select">
          <option value="2">Fila de espera</option>
          <option value="3">Convocado SP</option>
          <option value="4">Convocado RJ</option>
          <option value="5">Convocado RF</option>
          <option value="6">Menor</option>
          <option value="7">Incompleta</option>
          <option value="8">Cancelada</option>
          <option value="10">Efetivar</option>
          <option value="11">Apagar candidato do BD</option>
        </select>
        </label></td>
    </tr>
  </table>
  <INPUT TYPE=hidden NAME="num_candidato" VALUE="<?php echo $num_candidato; ?>">
  <input name="butEnvia" type="submit" value="Gravar" />
</form>
