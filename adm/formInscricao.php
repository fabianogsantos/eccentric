<?php
if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
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

$query_rsPaises = "SELECT * FROM pais";
$rsPaises = $con->query($query_rsPaises) or die(mysql_error());
$row_rsPaises = $rsPaises->fetch_assoc();
$totalRows_rsPaises = $rsPaises->num_rows;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $hoje = br2ansi(Date("d/m/y"));
  $cpf2 = preg_replace( '#[^0-9]#', '', $_POST['cpf']);
  $insertSQL = sprintf("INSERT INTO candidato (nome, nome_guerra, cidade, uf, pais, email, email2, nucleo, data_nasc, tel_cel,tel_res, profissao, versao_fs, voos_online, pid, vid, cpf, motivo, experiencia,data_inscricao,status) VALUES (%s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, '$hoje',1)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['nome_guerra'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['uf'], "text"),
                       GetSQLValueString($_POST['lstPais'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['email2'], "text"),
                       GetSQLValueString($_POST['nucleo'], "text"),
                       GetSQLValueString(br2ansi($_POST['data_nasc']), "date"),
                       GetSQLValueString($_POST['tel_res'], "text"),
                       GetSQLValueString($_POST['tel_cel'], "text"),
                       GetSQLValueString($_POST['profissao'], "text"),
                       GetSQLValueString($_POST['versao_fs'], "text"),
                       GetSQLValueString($_POST['voos_online'], "text"),
                       GetSQLValueString($_POST['pid'], "text"),
                       GetSQLValueString($_POST['vid'], "text"),
                       GetSQLValueString($cpf2, "text"),
                       GetSQLValueString($_POST['motivo'], "text"),
                       GetSQLValueString($_POST['experiencia'], "text"));
  $Result1 = $con->query($insertSQL);

  ?>
	<script language="Javascript">
	<!--
		alert("Dados enviados para inscrição!");
		window.open("index.php?pagina=inicio","_self");
	//-->
	</script>
  <?php
}

$query_rsNucleo = "SELECT * FROM nucleo";
$rsNucleo = $con->query($query_rsNucleo);
$row_rsNucleo = $rsNucleo->fetch_assoc();
$totalRows_rsNucleo = $rsNucleo->num_rows;

$query_rsPais = "SELECT * FROM pais";
$rsPais = $con->query($query_rsPais);
$row_rsPais = $rsPais->fetch_assoc();


?>
<h3 class="page-header">Ficha de Inscrição</h3>
<form class="form" data-toggle="validator" role="form" method="post" name="form1" action="<?php echo $editFormAction; ?>" >
  <label for="leuRegulamento">É fundamental que você  conheça as regras de funcionamento da Eccentric Travels antes de preencher sua Ficha de Inscrição. Você leu o <a href="Regulamento.htm" title="Leia o regulamento">Regulamento?</a></label>
  <div class="checkbox">
    <label><input type="checkbox" name="leuRegulamento" required>Li o regulamento</label>
    <div class="help-block with-errors"></div>
  </div>


  <div class="row">
  <div class="col-sm-6">
  <div class="form-group">
    <label for="nome">Nome completo *</label>
    <input class="form-control" name="nome" type="text" id="nome" required />
  </div>
  </div>

  <div class="col-sm-6">
  <div class="form-group">
    <label for="nome_guerra">Nome de guerra *</label>
    <input class="form-control" name="nome_guerra" type="text" id="nome_guerra" placeholder="Escolha entre seu nome ou um dos sobrenomes (sujeito a validação)" required />
  </div>
  </div>
  </div>

  <div class="row">
  <div class="col-sm-4">
  <div class="form-group">
    <label for="cidade">Cidade onde reside *</label>
    <input class="form-control" name="cidade" type="text" id="cidade" required />
  </div>
  </div>

  <div class="col-sm-4">
  <div class="form-group">
    <label for="uf">UF (Não selecionar se estrangeiro)</label>
    <select class="form-control" name="uf" id="uf">
    <option value="-1">Selecione</option>
    <option value="AC">AC</option>
    <option value="AM">AM</option>
    <option value="AP">AP</option>
    <option value="BA">BA</option>
    <option value="CE">CE</option>
    <option value="DF">DF</option>
    <option value="ES">ES</option>
    <option value="GO">GO</option>
    <option value="MA">MA</option>
    <option value="MG">MG</option>
    <option value="MS">MS</option>
    <option value="MT">MT</option>
    <option value="PB">PB</option>
    <option value="PE">PE</option>
    <option value="PI">PI</option>
    <option value="PA">PA</option>
    <option value="RJ">RJ</option>
    <option value="RO">RO</option>
    <option value="RN">RN</option>
    <option value="RR">RR</option>
    <option value="RS">RS</option>
    <option value="SC">SC</option>
    <option value="SE">SE</option>
    <option value="SP">SP</option>
    <option value="TO">TO</option>
  </select>
  </div>
  </div>

  <div class="col-sm-4">
  <div class="form-group">
  <label for="pais">País</label>
  <select class="form-control" name="lstPais" id="lstPais">
  <option value="-1">Selecione</option>
    <?php
    do {
    ?>
    <option value="<?php echo $row_rsPaises['cod_pais']?>"><?php echo $row_rsPaises['nome']?></option>
    <?php
    } while ($row_rsPaises = $rsPaises->fetch_assoc());
      $rows = $rsPaises->num_rows;
      if($rows > 0) {
        mysql_data_seek($rsPaises, 0);
	      $row_rsPaises = $rsPaises->fetch_assoc();
    }
    ?>
  </select>
  </div>
  </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label>Email principal *</label>
        <input class="form-control" name="email" type="email" id="email" required />
      </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
        <label>Email secundário</label>
        <input class="form-control" name="email2" type="email" id="email2" />
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label>Núcleo de sua preferência - Sujeito a validação *</label>
        <select class="form-control" name="nucleo" id="nucleo" required>
          <option value="-1">Selecione</option>
          <option value="rf">Recife</option>
          <option value="rj">Rio de Janeiro</option>
          <option value="sp">São Paulo</option>
        </select>
      </div>
    </div>

    <div class="col-sm-4">
      <div class="form-group">
        <label>Sua atividade profissional atual</label>
        <input class="form-control" name="profissao" type="text" id="profissao" required />
      </div>
    </div>
 </div>


  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label>Realiza vôos online?</label>
        <select class="form-control" name="voos_online" id="voos_online" required>
          <option value="-1">Selecione</option>
          <option value="s">Sim</option>
          <option value="n">Não</option>
        </select>
      </div>
    </div>

    <div class="col-sm-4">
      <div class="form-group">
        <label>PID (Vatsim)</label>
        <input class="form-control" name="pid" type="number" id="pid" value="0" />
      </div>
    </div>

    <div class="col-sm-4">
      <div class="form-group">
        <label>VID (Ivao)</label>
        <input class="form-control" name="vid" type="number" id="vid" value="0" />
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-3">
      <div class="form-group">
        <label>CPF</label>
          <input class="form-control" name="cpf" type="number" id="cpf"  onblur="return validarCPF()" onkeyup="FormataCpf(this,event)" placeholder="Obrigatório, menos para estrangeiros" />
      </div>
    </div>

    <div class="col-sm-3">
      <div class="form-group">
        <label>Data de nascimento</label>
        <input class="form-control" name="data_nasc" type="date" id="data_nasc" placeholder="dd/mm/aaaa" required />
      </div>
    </div>

    <div class="col-sm-3">
      <div class="form-group">
      <label>Telefone celular</label>
      <input class="form-control" name="tel_cel" type="number" id="tel_cel" placeholder="Com DDD, só números"/>
      </div>
    </div>

    <div class="col-sm-3">
      <div class="form-group">
      <label>Telefone fixo</label>
      <input class="form-control" name="tel_res" type="number" id="tel_res" placeholder="Com DDD, só números"/>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="experiencia">Qual sua experiência no FS</label>
        <select class="form-control" name="experiencia" id="experiencia" class="form-control">
          <option value="-1">Selecione</option>
          <option value="menos1">Menos de 1 ano</option>
          <option value="entre1e5">Entre 1 e 5 anos</option>
          <option value="entre6e10">Entre 6 e 10 anos</option>
          <option value="mais10">Mais de 10 anos</option>
        </select>
      </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
        <label>Qual a versão do FS que você usa?</label>
        <select class="form-control" name="versao_fs" id="versao_fs">
          <option value="-1">Selecione</option>
          <option value="2004">2004</option>
          <option value="FS-X">FS-X</option>
        </select>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="form-group">
      <label for="motivo">Por que você deseja participar da Eccentric ?*</label>
      <textarea class="form-control" name="motivo" id="motivo" required></textarea>
    </div>
  </div>

<!--
  <div class="row">
    <div class="form-group">
    <div class="g-recaptcha" data-sitekey="6LfArQ4TAAAAAAFcc3xm_8_IFzLLpF-8pMNSz8rj"></div>
    </div>
  </div>
-->

  <input type="hidden" name="MM_insert" value="form1">

  <p>O preenchimento incompleto ou indevido invalida este documento.</p>
  <div class="form-group">
    <input id="mensagem" name="btnsubmit" type="submit" value="Inscrever" class="btn btn-primary">
  </div>
</form>
