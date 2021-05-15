<?php
if ($_SERVER['REQUEST_METHOD']=='GET'){
  $callsign = $_GET['callsign'];

  $query = "SELECT * FROM piloto where callsign=$callsign";
  $res = $con->query($query);
  $row = $res->fetch_assoc();;
}
else {
	if ($_SERVER['REQUEST_METHOD']=='POST'){
		$callsign			= $_POST['Callsign'];
		$nome					=	$_POST['Nome'];
		$nome_guerra	= $_POST['NomeGuerra'];
		$cidade				= $_POST['Cidade'];
		$uf						= $_POST['UF'];
		$pais					= $_POST['Pais'];
		$senha				= $_POST['Senha'];
		$email				= $_POST['Email'];
		$email2				= $_POST['Email2'];
		$data_nasc		= $_POST['DataNascimento'];
		$profissao		= $_POST['Profissao'];
		$cpf					= $_POST['CPF'];
		$rg						= $_POST['RG'];
		$status = $_POST['status'];

    $sql = "UPDATE piloto SET nome='$nome', nome_guerra='$nome_guerra', cidade='$cidade', uf='$uf', pais='$pais', senha='$senha', email='$email', email2='$email2', data_nasc='$data_nasc', profissao='$profissao', cpf='$cpf', rg='$rg', status='$status' where callsign = $callsign";
    $res = $con->query($sql);
    $url = $_SERVER['PHP_SELF']."?pagina=pilotos/pilotos";
    echo "<script>window.location = \"".$url."\"</script>";
  }

}
?>
<div class="page-header">
	<h3>Piloto</h3>
</div>

<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?pagina=pilotos/piloto";?>" method="POST" role="form">
	<legend>Dados Pessoais do Piloto</legend>

	<div class="form-group">
		<label for="inputCallsign" class="col-sm-2 control-label">Callsign:</label>
		<div class="col-sm-10">
			<input type="text" name="Callsign" id="inputCallsign" class="form-control" value="<?=$row['callsign']?>" readonly>
		</div>
	</div>

	<div class="form-group">
		<label for="inputNome" class="col-sm-2 control-label">Nome:</label>
		<div class="col-sm-10">
			<input type="text" name="Nome" id="inputNome" class="form-control" value="<?=$row['nome']?>" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputNomeGuerra" class="col-sm-2 control-label">Nome de Guerra:</label>
		<div class="col-sm-10">
			<input type="text" name="NomeGuerra" id="inputNomeGuerra" class="form-control" value="<?=$row['nome_guerra']?>" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputCidade" class="col-sm-2 control-label">Cidade:</label>
		<div class="col-sm-10">
			<input type="text" name="Cidade" id="inputCidade" class="form-control" value="<?=$row['cidade']?>" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputUF" class="col-sm-2 control-label">UF (sigla):</label>
		<div class="col-sm-10">
			<input type="text" name="UF" id="inputUF" class="form-control" value="<?=$row['uf']?>">
		</div>
	</div>

	<div class="form-group">
		<label for="inputPais" class="col-sm-2 control-label">País:</label>
		<div class="col-sm-10">
			<input type="text" name="Pais" id="inputPais" class="form-control" value="<?=$row['pais']?>" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputSenha" class="col-sm-2 control-label">Senha:</label>
		<div class="col-sm-10">
			<input type="password" name="Senha" id="inputSenha" class="form-control" required="required" value="<?=$row['senha']?>">
		</div>
	</div>

	<div class="form-group">
		<label for="inputEmail" class="col-sm-2 control-label">Email:</label>
		<div class="col-sm-10">
			<input type="email" name="Email" id="inputEmail" class="form-control" value="<?=$row['email']?>" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputEmail2" class="col-sm-2 control-label">Email secundário:</label>
		<div class="col-sm-10">
			<input type="email" name="Email2" id="inputEmail2" class="form-control" value="<?=$row['email2']?>">
		</div>
	</div>

	<div class="form-group">
		<label for="inputDataNascimento" class="col-sm-2 control-label">Data de Nascimento:</label>
		<div class="col-sm-10">
			<input type="date" name="DataNascimento" id="inputDataNascimento" class="form-control" value="<?=$row['data_nasc']?>" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputTelefone" class="col-sm-2 control-label">Telefone:</label>
		<div class="col-sm-10">
			<input type="tel" name="Telefone" id="inputTelefone" class="form-control" value="<?=$row['tel_res']?>" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputProfissao" class="col-sm-2 control-label">Profissão:</label>
		<div class="col-sm-10">
			<input type="text" name="Profissao" id="inputProfissao" class="form-control" value="<?=$row['profissao']?>" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputCPF" class="col-sm-2 control-label">CPF:</label>
		<div class="col-sm-10">
			<input type="number" name="CPF" id="inputCPF" class="form-control" value="<?=$row['cpf']?>">
		</div>
	</div>

	<div class="form-group">
		<label for="inputRG" class="col-sm-2 control-label">RG:</label>
		<div class="col-sm-10">
			<input type="text" name="RG" id="inputRG" class="form-control" value="<?=$row['rg']?>">
		</div>
	</div>
	
	<div class="form-group">
		<label for="ativo" class="col-sm-2 control-label">Status:</label>
		<div class="col-sm-10">
            <select class="form-control" id="status" name="status">
                <option value="a" <?php if ($row['status']=='a') echo 'selected'; ?>>Ativo</option>
                <option value="i" <?php if ($row['status']=='i') echo 'selected';?>>Inativo</option>
                <option value="c" <?php if ($row['status']=='c') echo 'selected'; ?>>Candidato</option>
            </select>
	</div>
	</div>

	<button type="submit" class="btn btn-primary">Salvar</button>
</form>





