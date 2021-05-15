<?php
if ($_SERVER['REQUEST_METHOD']=='GET'){
  $cod_aeronave = $_GET['cod_aeronave'];

  $query = "SELECT * FROM aeronave where cod_aeronave=$cod_aeronave";
  $rsAeronaves = $con->query($query);
  $row = $rsAeronaves->fetch_assoc();
  $totalRows = $rsAeronaves->num_rows;

  $query_rsPosto = "SELECT * FROM posto";
  $rsPosto = $con->query($query_rsPosto);
  $row_rsPosto = $rsPosto->fetch_assoc();
  $totalRows_rsPosto = $rsPosto->num_rows;
}
else {
  if ($_SERVER['REQUEST_METHOD']=='POST'){
    $prefixo              = $_POST['prefixo'];
    $nome                 = $_POST['nome'];
    $nome_guerra          = $_POST['nome_guerra'];
    $data_inicio          = $_POST['data_inicio'];
    $versao                = $_POST['versao'];
    $flg_aeronave_primaria = $_POST['flg_aeronave_primaria'];
    $cod_posto             = $_POST['cod_posto'];
    $cod_aeronave         = $_POST['cod_aeronave'];
    $tipo_aeronave        = $_POST['tipo_aeronave'];
    $nome_arq = $_POST['nome_arq_fs9'];
    $status = $_POST['status'];
    $kts_cruz = $_POST['kts_cruz'];
    $min_adic = $_POST['min_adic'];
    $auton_nm = $_POST['auton_nm'];
    $capac_gls = $_POST['capac_gls'];
    $nome_arq_fsx = $_POST['nome_arq_fsx'];

    if (empty($_FILES['fileToUpload']["name"])){
        $imagem_2 = $_POST['imagem_2'];
    }
    else {
        $imagem_2 = $_FILES['fileToUpload']["name"];
        upload('../imagens/aeronaves/');
    }

    $sql = "UPDATE aeronave SET prefixo='$prefixo', nome='$nome',nome_guerra='$nome_guerra',data_inicio='$data_inicio',versao='$versao',flg_aeronave_primaria='$flg_aeronave_primaria',cod_posto=$cod_posto,cod_aeronave=$cod_aeronave,tipo_aeronave='$tipo_aeronave',imagem_2='$imagem_2',nome_arq='$nome_arq',status='$status',kts_cruz=$kts_cruz,min_adic=$min_adic,auton_nm=$auton_nm,capac_gls=$capac_gls,nome_arq_fsx='$nome_arq_fsx' where cod_aeronave = $cod_aeronave";
    
    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=aeronaves/aeronaves";
    echo "<script>window.location = \"".$url."\"</script>";
  }
}
?>
<div class="page-header">
  <h3>Cadastro de Aeronaves</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=aeronaves/aeronave";?>" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="cod_aeronave">Código interno</label>
        <input class="form-control" type="number" name="cod_aeronave" value="<?php echo $row['cod_aeronave']; ?>">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="prefixo">Prefixo</label>
        <input class="form-control"  name="prefixo" type="text" id="pref" value="<?php echo $row['prefixo']; ?>">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input class="form-control"  type="text" name="nome" value="<?php echo $row['nome']; ?>"  >
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="nome_guerra">Nome de guerra</label>
        <input class="form-control"  type="text" name="nome_guerra" value="<?php echo $row['nome_guerra']; ?>"  >
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="data_inicio">Início das operações</label>
        <input class="form-control" type="date" name="data_inicio" value="<?php echo $row['data_inicio']; ?>">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="versao">Versão</label>
        <input class="form-control"  type="text" name="versao" value="<?php echo $row['versao']; ?>">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="flg_aeronave_primaria">Aeronave primária</label>
        <select name="flg_aeronave_primaria" class="form-control">
          <option value="1" <?php if (!(strcmp(1, $row['flg_aeronave_primaria']))) {echo "SELECTED";} ?>>Sim</option>
          <option value="0" <?php if (!(strcmp(0, $row['flg_aeronave_primaria']))) {echo "SELECTED";} ?>>Não</option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="cod_posto">Posto</label>
        <select name="cod_posto" class="form-control">
          <?php
          do {
            echo "<option value=\"".$row_rsPosto['cod_posto']."\"";
            if (!(strcmp($row_rsPosto['cod_posto'], $row['cod_posto']))) echo "SELECTED";
            echo ">";
            echo $row_rsPosto['nome_posto_curto']."</option>";
          } while ($row_rsPosto = $rsPosto->fetch_assoc());
          ?>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form_group">
        <label for="tipo_aeronave">Tipo de aeronave</label>
        <select name="tipo_aeronave" class="form-control">
          <option value="p" <?php if (!(strcmp("p", $row['tipo_aeronave']))) {echo "SELECTED";} ?>>Passageiros</option>
          <option value="c" <?php if (!(strcmp("c", $row['tipo_aeronave']))) {echo "SELECTED";} ?>>Cargas</option>
          <option value="t" <?php if (!(strcmp("t", $row['tipo_aeronave']))) {echo "SELECTED";} ?>>Táxi aéreo</option>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="status">Ativa?</label>
        <select name="status" class="form-control">
          <option value="a" <?php if (!(strcmp("a", $row['status']))) {echo "SELECTED";} ?>>Sim</option>
          <option value="i" <?php if (!(strcmp("i", $row['status']))) {echo "SELECTED";} ?>>Não</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="nome_arq_fs9">Nome arquivo FS9</label>
        <input class="form-control"  type="text" name="nome_arq_fs9" value="<?php echo $row['nome_arq']; ?>" >
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="nome_arq_fsx">Nome arquivo FSX</label>
        <input class="form-control"  type="text" name="nome_arq_fsx" value="<?php echo $row['nome_arq_fsx']; ?>" >
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="imagem_2">Nome arquivo imagem</label>
        <input class="form-control"  type="text" name="imagem_2" value="<?php echo $row['imagem_2']; ?>" >
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="kts_cruz">Kts Cruzeiro</label>
        <input class="form-control"  type="number" name="kts_cruz" value="<?php echo $row['kts_cruz']; ?>">    
      </div>
    </div>
    <div class="col-md-3">
      <label for="min_adic">Min adic</label>
      <input class="form-control"  type="number" name="min_adic" value="<?php echo $row['min_adic']; ?>">
    </div>
    <div class="col-md-3">
      <label for="auton_nm">Autonomia(nm)</label>
      <input class="form-control"  type="number" name="auton_nm" value="<?php echo $row['auton_nm']; ?>">
    </div>
    <div class="col-md-3">
      <label for="capac_gls">Capacidade(Gls)</label>
      <input class="form-control"  type="number" name="capac_gls" value="<?php echo $row['capac_gls']; ?>">
    </div>
  </div>
  <div class="row">
    <div class="form-group">
      <div class="col-md-6">
        <label for="imagem_2">Imagem</label>
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="form-group">
      <div class="col-md-6">
        <br>
        <img name="imagem_2" id="imagem_2" src="<?='../imagens/aeronaves/'.$row['imagem_2']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="form-group">
      <div class="col-md-6">
        <br>
        <input class="btn btn-primary"  name="Submit" type="submit" value="Gravar!">
        <a href="index.php?pagina=aeronaves/apaga&cod_aeronave=<?=$cod_aeronave?>" class="btn btn-danger"  role="button">Apagar</a>        
      </div>
    </div>
  </div>
  </form>  
  <hr>
  <div class="alert alert-danger" role="alert">
    <p>Os arquivos executáveis devem ser enviados por ftp para o diretório: <?=$dir_arquivo_aeronaves ?></p>
  </div>