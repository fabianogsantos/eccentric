<?php
if ($_SERVER['REQUEST_METHOD']=='GET'){
  $id = $_GET['id'];

  $query = "SELECT id,DATE_FORMAT(data,'%d/%m/%Y') AS _data,nome,email,mensagem FROM livro_visitas where id=$id";
  $rs = $con->query($query);
  $row = $rs->fetch_assoc();

  $sql = "update livro_visitas set respondido=1 where id=$id";
  $con->query($sql);
}
else {
  $id = $_POST['id'];
  $sql = "delete from livro_visitas where id=$id";
  $con->query($sql);

  echo "<script language=\"JavaScript\">
          window.location=\"index.php?pagina=visitas/visitas\"; 
        </script> ";
}
?>
<div class="page-header">
  <h3>Livro de Visitas</h3>
</div>
<form method="post" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=visitas/visita";?>">
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="id">Data</label>
        <input class="form-control"  readonly type="text" name="data" value="<?php echo $row['_data']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="nome_arq_fs9">Nome</label>
        <input class="form-control" readonly type="text" name="nome" value="<?php echo $row['nome']; ?>" >
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="id">Email</label>
        <input class="form-control" readonly type="text" name="email" value="<?php echo $row['email']; ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="id">Mensagem</label>
        <input class="form-control" readonly type="text" name="mensagem" value="<?php echo $row['mensagem']; ?>">
      </div>
    </div>
  </div>
  <input type="hidden" name="id" value="<?=$id;?>">
  <a href="index.php?pagina=visitas/visitas" class="btn btn-primary">Voltar</a>
  <button type="submit" class="btn btn-danger">Apagar</button>
  <p>A ação de apagar vai eliminar o registro completamente!</p>
</form>
