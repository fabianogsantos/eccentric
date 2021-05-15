<?php
	if(!isset($_SESSION["callsign"])){
		?><script language="Javascript">
				window.open("index.php?pagina=pagina&pid=10","_parent");
		</script><?
    	exit;
	}

$callsign = $_SESSION["callsign"];
include('configura.php');

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$cidade = $_POST['cidade'];
	$uf=$_POST['uf'];
	$cod_pais = $_POST['cod_pais'];
	$senha = $_POST['senha'];
	$email2 = $_POST['email2'];
	$imagem = $_POST['imagem'];
	$tel_res = $_POST['tel_res'];
	$profissao = $_POST['profissao'];
	$pid = $_POST['pid'];
	$vid = $_POST['vid'];
  	$sql = "UPDATE piloto SET cidade='$cidade',uf='$uf',cod_pais='$pais',senha='$senha',email2='$email2',imagem='$imagem',tel_res='$tel_res',profissao='$profissao',pid='$pid', vid='$vid' WHERE callsign=$callsign";
  $Result1 = $con->query($sql);
}

$sql1 = "select * from piloto where status = 'a' and callsign =$callsign";
$res1 = $con->query($sql1);
$row1 = $res1->fetch_assoc();
$num_rows1 = $res->num_rows;

$query2 = "SELECT * FROM pais";
$res2 = $con->query($query2);
$row2 = $res2->fetch_assoc();
$num_rows2 = $res2->num_rows;
?>

<div class="row">
	<div class="col-md-10">
		<form class="form-horizontal" action="<?php echo $editFormAction; ?>" method="post">
			<fieldset>
				<legend>Alteração de dados cadastrais</legend>
				<p>Alguns campos estão desabilitados por medida de segurança. Caso deseje alterá-los, entre em contato com o <a href="mailto:presidente@eccentrictravels.org?subject=Alterao de dados cadastrais">nosso presidente</a>.</p>
			</fieldset>

			<div class="form-group">
				<label class="col-md-4 control-label" for="callsign">Callsign</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						</div>
						<input id="callsign" name="Callsign" type="text" class="form-control input-md" value="<?php echo $row1['callsign']; ?>" readonly="true"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="nome">Nome</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-font" aria-hidden="true"></span>
						</div>
						<input id="nome" name="nome" type="text" class="form-control input-md" value="<?php echo $row1['nome']; ?>" readonly="true"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="Upload photo">Alterar foto</label>
				<div class="col-md-4">
					<input id="Enviar outra foto" name="foto" class="input-file" type="file">
				</div>
			</div>

			<div class="form-group">
				<label for="senha" class="col-md-4 control-label">Senha</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
						</div>
						<input type="password" class="form-control input-md" name="senha" value="<?php echo $row['senha'];?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="email">Email principal</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
						</div>
						<input id="email" name="email" type="text" class="form-control input-md" value="<?php echo $row1['email']; ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="email2">Email secundário</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
						</div>
						<input id="email2" name="email2" type="text" class="form-control input-md" value="<?php echo $row1['email2']; ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="pid" class="col-md-4 control-label">PID (Vatsim)</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-plane" aria-hidden="true"></span>
						</div>
						<input id="pid" class="form-control input-md" name="pid" type="text" value="<?php echo $row1['pid']; ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="vid" class="col-md-4 control-label">VID (Ivao)</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-plane" aria-hidden="true"></span>
						</div>
						<input id="vid" class="form-control input-md" name="vid" type="text" value="<?php echo $row1['vid']; ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="flynet" class="col-md-4 control-label">Outras redes</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-plane" aria-hidden="true"></span>
						</div>
						<input id="flynet" class="form-control input-md" name="flynet" type="text" value="<?php echo $row1['flynet']; ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="cidade">Cidade</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
						</div>
						<input id="cidade" name="cidade" type="text" class="form-control input-md" value="<?php echo $row1['cidade']; ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="uf">Estado</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
						</div>
						<input id="uf" name="uf" type="text" class="form-control input-md" value="<?php echo $row1['uf']; ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="pais" class="col-md-4 control-label">País</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
						</div>
						<select class="form-control" name="pais" id="pais">
							<?php
							do {
								?>
								<option value="<?php echo $row2['cod_pais'];?>"
									<?php
									if (strcmp($row2['cod_pais'],$row1['cod_pais'])==0) {echo "SELECTED";}
									?>>
									<?php echo $row2['nome']?>
								</option>
								<?php
							} while ($row2 = $res2->fetch_assoc());
							$rows = $row2->num_rows;
							if($rows > 0) {
								mysql_data_seek($rsPaises, 0);
								$row2 = $res2->fetch_assoc();
							}
							?>
					</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="data_nasc">Data de nascimento</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
						</div>
						<input id="data_nasc" name="data_nasc" type="text" class="form-control input-md" value="<?php echo ansi2br($row1['data_nasc']); ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="tel_cel">Telefone celular</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
						</div>
						<input id="tel_cel" name="tel_cel" type="text" class="form-control input-md" value="<?php echo $row1['tel_res']; ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="cpf">CPF</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
						</div>
						<input id="cpf" name="cpf" type="text" class="form-control input-md" value="<?php echo $row1['cpf']; ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="tel_cel">RG</label>
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
						</div>
						<input id="rg" name="rg" type="text" class="form-control input-md" value="<?php echo $row1['cpf']; ?>"/>
					</div>
				</div>
			</div>

			<div class="form-group">
  			<label class="col-md-4 control-label" ></label>
  			<div class="col-md-4">
  				<a href="#" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span> Gravar</a>
  				<a href="#" class="btn btn-danger" value=""><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</a>
				</div>
			</div>

			<input type="hidden" name="MM_update" value="form1" />
			<input type="hidden" name="imagem" value="<?php echo $row1['imagem'];   ?>"  />
			<input type="hidden" name="callsign" value="<?php echo $row1['callsign']; ?>" />

		</form>
	</div>
	<div class="col-md-2 hidden-xs">
		<img src="<?php echo $dir_imagem_pilotos.$row1['imagem'];?>" class="img-responsive img-thumbnail ">
  </div>
</div>
