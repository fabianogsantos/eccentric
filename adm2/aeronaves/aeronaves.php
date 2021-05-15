<?php 	
	if(!isset($_SESSION["callsign"])){
		echo "<p align='center'>Área restrita aos pilotos da Eccentric Travels</p>";
	}
	else {
		$callsign = $_SESSION['callsign'];
		$link =  "aeronaves/json.php";
?>

<div class="page-header">
  <h3>Cadastro de Aeronaves</h3>
</div>
<div class="bootstrap-table">
    <div class="fixed-table-toolbar">
      <div class="bs-bars float-left">
        <div id="toolbar">
          <a href="index.php?pagina=aeronaves/insere" class="btn btn-primary" role="button">Inserir</a>
        </div>
        <table id="table"
          data-pagination="True"
          data-page-size="20"
          data-toggle="table"
          data-pagination="True"
          data-search="True"
          data-url="<?=$link?>"
          data-toolbar="#toolbar"
          >
          <thead>
            <tr>
              <th data-field="cod_aeronave" data-formatter="LinkFormatterCodAeronave">Código</th>
              <th data-field="nome">Nome</th>
              <th data-field="versao">Versão</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
</div>
<?php } ?>
