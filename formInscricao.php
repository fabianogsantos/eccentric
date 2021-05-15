<?php
    $insert = empty($ins)?'':'s';

    $query_rsPaises = "SELECT * FROM pais";
    $rsPaises = $con->query($query_rsPaises) or die(mysql_error());
    $row_rsPaises = $rsPaises->fetch_assoc();
    $totalRows_rsPaises = $rsPaises->num_rows;

    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
      $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }

    if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
      	//RECAPTCHA
      $url = "https://www.google.com/recaptcha/api/siteverify";
      $respon = $_POST['g-recaptcha-response'];

      $data = array('secret' => "6LfzAaYUAAAAAOWe8Gv5WWlWnFm3aGVZd7Os5Zdk", 'response' => $respon);

      $options = array(
          'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)

          )
      );
      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);
      $jsom = json_decode($result);

      if (!$jsom->success) {
        echo "<div class=\"alert alert-danger\"><a href='index.php?pagina=formInscricao'>Erro no recaptcha. Tente novamente.</a></div>";
        die();
      }
      

      if (!empty($_POST['website'])) die();

      $hoje = br2ansi(Date("d/m/y"));
      $cpf = preg_replace( '#[^0-9]#', '', $_POST['cpf']);

      $nome         = $_POST['nome'];
      $nome_guerra  = $_POST['nome_guerra'];
      $cidade       = $_POST['cidade'];
      $uf           = $_POST['uf'];
      $pais         = $_POST['lstPais'];
      $email        = $_POST['email'];
      $email2       = $_POST['email2'];
      $nucleo       = $_POST['nucleo'];
      $data_nasc    = br2ansi($_POST['data_nasc']);
      $tel_cel      = $_POST['tel_cel'];
      $tel_res      = $_POST['tel_res'];
      $profissao    = $_POST['profissao'];
      $versao_fs    = $_POST['versao_fs'];
      $voos_online  = $_POST['voos_online'];
      $pid          = $_POST['pid'];
      $vid          = $_POST['vid'];
      $motivo       = $_POST['motivo'];
      $experiencia  = $_POST['experiencia'];


      $insertSQL = "INSERT INTO candidato (nome, nome_guerra, cidade, uf, pais, email, email2, nucleo, data_nasc, tel_cel,tel_res, profissao, versao_fs, voos_online, pid, vid, cpf, motivo, experiencia,data_inscricao,status) VALUES ('$nome','$nome_guerra','$cidade','$uf','$pais','$email','$email2','$nucleo','$data_nasc','$tel_cel','$tel_res','$profissao','$versao_fs','$voos_online','$pid','$vid','$cpf','$motivo','$experiencia','$hoje',1)";
      $Result1 = $con->query($insertSQL);

      echo "<p>Seus dados foram enviados com sucesso. Aguarde nosso contato.</p><br><hr>";
    }

    else {
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
          mysqli_data_seek($rsPaises, 0);
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
          <input class="form-control" name="profissao" type="text" id="profissao" />
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
            <option value="P3D">P3D</option>
            <option value="XPLA">X-Plane</option>
            <option value="Outros">Outros</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="motivo">Por que você deseja participar da Eccentric ?*</label>
          <textarea class="form-control" name="motivo" id="motivo" required></textarea>
        </div>
      </div>
    </div>

    <input type="hidden" name="MM_insert" value="form1">
    <input type="text" name="website" id="website" class="naomostra">

    <p>O preenchimento incompleto ou indevido invalida este documento.</p>
    <div class="form-group">
      <div class="g-recaptcha" data-sitekey="6LfzAaYUAAAAABauyhGhAiWeVwfwxn6zOoNi-Hwj"></div>
      <input id="mensagem" name="btnsubmit" type="submit" value="Inscrever" class="btn btn-primary">
    </div>
  </form>
<?php
}
?>
