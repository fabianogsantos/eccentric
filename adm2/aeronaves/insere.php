<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $prefixo = $_POST['prefixo'];
    $nome = $_POST['nome'];
    $nome_guerra = $_POST['nome_guerra'];
    $data_inicio = $_POST['data_inicio'];
    $versao = $_POST['versao'];
    $flg_aeronave_primaria = $_POST['flg_aeronave_primaria'];
    $cod_posto = $_POST['cod_posto'];
    $cod_aeronave = $_POST['cod_aeronave'];
    $tipo_aeronave = $_POST['tipo_aeronave'];
    $imagem_2 = $_FILES['fileToUpload']["name"];
    $nome_arq = $_POST['nome_arq_fs9'];
    $status = $_POST['status'];
    $kts_cruz = $_POST['kts_cruz'];
    $min_adic = $_POST['min_adic'];
    $auton_nm = $_POST['auton_nm'];
    $capac_gls = $_POST['capac_gls'];
    $nome_arq_fsx = $_POST['nome_arq_fsx'];

   
    upload('../imagens/aeronaves/');

    $sql = "INSERT into aeronave (prefixo, nome,nome_guerra,data_inicio,versao,flg_aeronave_primaria,cod_posto,cod_aeronave,tipo_aeronave,imagem_2,nome_arq,status,kts_cruz,min_adic,auton_nm,capac_gls,nome_arq_fsx) values ('$prefixo','$nome','$nome_guerra','$data_inicio','$versao','$flg_aeronave_primaria',$cod_posto,$cod_aeronave,'$tipo_aeronave','$imagem_2','$nome_arq','$status',$kts_cruz,$min_adic,$auton_nm,$capac_gls,'$nome_arq_fsx')";
    
    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=aeronaves/aeronaves";
    echo "<script>window.location = \"".$url."\"</script>";
}
?>
<div class="page-header">
  <h3>Cadastro de Aeronaves</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=aeronaves/insere";?>" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="cod_aeronave">Código interno</label>
        <input class="form-control" type="number" name="cod_aeronave">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="prefixo">Prefixo</label>
        <input class="form-control"  name="prefixo" type="text" id="pref" >
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input class="form-control"  type="text" name="nome">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="nome_guerra">Nome de guerra</label>
        <input class="form-control"  type="text" name="nome_guerra">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="data_inicio">Data de início das operações</label>
        <input class="form-control"  type="date" name="data_inicio">
      </div>
    </div>
    <div class="col-md-1">
      <div class="form-group">
        <label for="versao">Versão</label>
        <input class="form-control"  type="text" name="versao">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="flg_aeronave_primaria">Aeronave primária</label>
        <select name="flg_aeronave_primaria" class="form-control">
          <option value="1">Sim</option>
          <option value="0">Não</option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="cod_posto">Posto</label>
        <select name="cod_posto" class="form-control">
          <option value="1">Primeiro oficial regional</option>
          <option value="2">Co-piloto regional</option>
          <option value="3">Comandante regional</option>
          <option value="4">Primeiro oficial regional</option>
          <option value="5">Co-piloto internacional</option>
          <option value="6">Comandante internacional</option>
          <option value="7">Comandante Transcontinental</option>
          <option value="8">Sky master</option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form_group">
        <label for="tipo_aeronave">Tipo de aeronave</label>
        <select name="tipo_aeronave" class="form-control">
          <option value="p">Passageiros</option>
          <option value="c">Cargas</option>
          <option value="t">Táxi aéreo</option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="status">Ativa?</label>
        <select name="status" class="form-control">
          <option value="a">Sim</option>
          <option value="i">Não</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="nome_arq_fs9">Nome arquivo FS9</label>
        <input class="form-control" type="text" name="nome_arq_fs9" >
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="nome_arq_fsx">Nome arquivo FSX</label>
        <input class="form-control"  type="text" name="nome_arq_fsx">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="imagem_2">Nome arquivo imagem</label>
        <input class="form-control"  type="text" name="imagem_2">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <label for="kts_cruz">Kts Cruzeiro</label>
      <input class="form-control"  type="number" name="kts_cruz">
    </div>
    <div class="col-md-3">
      <label for="min_adic">Min adic</label>
      <input class="form-control"  type="number" name="min_adic">
    </div>
    <div class="col-md-3">
      <label for="auton_nm">Autonomia(nm)</label>
      <input class="form-control"  type="number" name="auton_nm">
    </div>
    <div class="col-md-3">
      <label for="capac_gls">Capacidade(Gls)</label>
      <input class="form-control"  type="number" name="capac_gls">
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <label for="fileToUpload">Imagem atual</label>
      <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
    </div>
  </div>
  <br><br>
  <input class="btn btn-primary"  name="Submit" type="submit" value="Gravar!">
  <hr>
  <div class="alert alert-danger" role="alert">
    <p>Após gravar os dados, o arquivo executável deve ser enviado por ftp para o diretório: <?=$dir_arquivo_aeronaves ?><br>
    Os arquivos das imagens devem ser enviados por ftp para o diretório: <?=$dir_imagem_aeronaves ?></p>
  </div>
</form>
