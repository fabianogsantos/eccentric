<?php
  $num_candidato = $_GET['num_candidato'];
  $query_rsCandidato = "SELECT * FROM candidato where num_candidato=$num_candidato";
  $rsCandidato = $con->query($query_rsCandidato);
  $row_rsCandidato = $rsCandidato->fetch_assoc();

  $query_rsNucleo = "SELECT * FROM nucleo";
  $rsNucleo = $con->query($query_rsNucleo) ;
  $row_rsNucleo = $rsNucleo->fetch_assoc();

  $query_rsPaises = "select p.nome from pais p,candidato c where p.cod_pais=c.pais and num_candidato=$num_candidato";
  $rsPaises = $con->query($query_rsPaises);
  $row_rsPaises = $rsPaises->fetch_assoc();
?>

<h3>Dados do candidato</h3>
<form name="dados_candidato" action="index.php?pagina=fila_espera/efetiva_candidato" method="post">
  <div class="row">
    <div class="col-md-2">
      <div class="form_group">
        <label for="num_candidato">Número</label>
        <input type="text" name="num_candidao" value="<?=$row_rsCandidato['num_candidato']?>" class="form-control" readonly>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form_group">
        <label for="nome_guerra">Nome de guerra</label>
        <input type="text" name="nome_guerra" value="<?=$row_rsCandidato['nome_guerra']?>" class="form-control" readonly>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form_group">
        <label for="nome">Nome</label>
        <input type="text" name="nome" value="<?=$row_rsCandidato['nome']?>" class="form-control" readonly>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4"><div class="form_group">
      <label for="data_nasc">Data de nascimento</label>
      <input type="text" name="data_nasc" value="<?=ansi2br($row_rsCandidato['data_nasc'])?>" class="form-control" readonly>
    </div></div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form_group">
        <label for="cidade">Cidade</label>
        <input type="text" name="cidade" value="<?=$row_rsCandidato['cidade']?>" class="form-control" readonly>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form_group">
        <label for="uf">Estado</label>
        <input type="text" name="uf" value="<?=$row_rsCandidato['uf']?>" class="form-control" readonly>
      </div>
    </div>

    <div class="col-md-4">
      <label for="pais">País</label>
      <input type="text" name="pais" value="<?=$row_rsPaises['nome']?>" class="form-control" readonly>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form_group">
        <label for="tel_res">Telefone residencial</label>
        <input type="text" name="tel_res" value="<?=$row_rsCandidato['tel_res']?>" class="form-control" readonly>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form_group">
        <label for="tel_cel">Telefone celular</label>
        <input type="text" name="tel_cel" value="<?=$row_rsCandidato['tel_cel']?>" class="form-control" readonly>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4"><div class="form_group">
      <label for="tel_cel">Profissão</label>
      <input type="text" name="profissao" value="<?=$row_rsCandidato['profissao']?>" class="form-control" readonly>
    </div></div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form_group">
        <label for="email">Email</label>
        <input type="text" name="email" value="<?=$row_rsCandidato['email']?>" class="form-control" readonly>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="email2">Email secundário</label>
        <input type="text" name="email2" value="<?=$row_rsCandidato['email2']?>" class="form-control" readonly>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form_group">
        <label for="nucleo">Núcleo</label>
        <input type="text" name="nucleo" value="<?=$row_rsCandidato['nucleo']?>" class="form-control" > bh= Belo Horizonte, re = Recife, rj = Rio de Janeiro, sp = São Paulo 
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form_group">
        <label for="versao_fs">Versão do Flight Simulator</label>
        <input type="text" name="versao_fs" value="<?=$row_rsCandidato['versao_fs']?>" class="form-control" readonly>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form_group">
        <label for="voos_online">Realiza vôos online?</label>
        <input type="text" name="versao_fs" value="<?=trataVooOnline($row_rsCandidato['voos_online'])?>" class="form-control" readonly>
      </div>
    </div>
    <div class="col-md-4">
      <label for="pid">Pid (Vatsim)</label>
      <input type="text" name="pid" value="<?=$row_rsCandidato['pid']?>" class="form-control" readonly>
    </div>
    <div class="col-md-4">
      <label for="vid">Vid (IVAO)</label>
      <input type="text" name="pid" value="<?=$row_rsCandidato['vid']?>" class="form-control" readonly>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form_group">
        <label for="cpf">Cpf</label>
        <input type="text" name="cpf" value="<?=$row_rsCandidato['cpf']?>" class="form-control" readonly>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="rg">RG</label>
        <input type="text" name="rg" value="<?=$row_rsCandidato['rg']?>" class="form-control" readonly>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form_group">
        <label for="experiencia">Experiência</label>
        <input type="text" name="experiencia" value="<?=$row_rsCandidato['experiencia']?>" class="form-control" readonly>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form_group">
        <label for="motivo">Motivo</label>
        <textarea name="motivo" class="form-control" readonly><?=$row_rsCandidato['motivo']?></textarea>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form_group">
        <label for="acao">Ação</label>
        <select name="acao" id="acao" class="form-control">
          <option value="2">Fila de espera</option>
          <option value="3">Convocado SP</option>
          <option value="4">Convocado RJ</option>
          <option value="5">Convocado RF</option>
          <option value="6">Menor</option>
          <option value="7">Incompleta</option>
          <option value="8">Cancelada</option>
          <option value="10">Efetivar</option>
        </select>
      </div>
    </div>
  </div>
  <br>
  <input name="butEnvia" type="submit" value="Gravar" class="btn btn-primary"/>
  <a href="index.php?pagina=fila_espera/apaga_candidato&num_candidato=<?=$num_candidato?>" class="btn btn-danger">Apagar!</a>
  <INPUT TYPE=hidden NAME="num_candidato" VALUE="<?php echo $num_candidato; ?>">
</form>
<p>O botão Apagar remove os dados do candidato do banco de dados</p>
