<?php
if (isset($_POST["mensagem"])||isset($_POST["enviar"])) {

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

	if ($jsom->success) {
		// sucesso 
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$mensagem = $_POST['mensagem'];
		$humano = intval($_POST['humano']);
	
		// Check if name has been entered
		if (!$_POST['nome']) {
			$erro_nome = 'Por favor digite seu nome';
		}
		else {
			$erro_nome='';
		}
	
		// Check if email has been entered and is valid
		if (!$_POST['email']) {
			$erro_email = 'Digite um e-mail válido';
		}
		else {
			$erro_email = '';
		}
	
		if (!$_POST['mensagem']) {
			$erro_mensagem = 'Por favor digite sua mensagem';
		}
		else {
			$erro_mensagem = '';
		}
	
		if ($humano !== 5) {
			$erro_humano = 'O resultado da conta está errado. Isto serve para verificar se você realmente é um humano ao digitar os dados no formulário :-)';
		}
		else {
			$erro_humano='';
		}
	
		if ($erro_nome=='' && $erro_email=='' && $erro_mensagem=='' && $erro_humano==''){
			$hoje = date("Y-m-d");
			$sql = "insert into livro_visitas (data,nome,mensagem,email) values ('$hoje','$nome','$mensagem','$email')";
			if ($con->query($sql)==TRUE)
				$submit = '<div class="alert alert-success">Obrigado pela sua mensagem!</div>';
			else
				$submit = '<div class="alert alert-danger">Houve um erro no envio da sua mensagem. Tente novamente por favor.</div>';
		}
		else {
			$submit = '<div class="alert alert-danger">Houve um erro no envio da sua mensagem. Tente novamente por favor.</div>';
		}
	} 
	else {
		//captcha invalido
		$submit = '<div class="alert alert-danger">Tente novamente por favor.</div>';
	}
}
?>
<h1 class="page-header">Entre em contato</h1>
<div class="row">
	<form class="form-horizontal" role="form" method="post" action="index.php?pagina=contato">
		<div class="form-group">
			<label for="nome" class="col-sm-2 control-label">Nome</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" value="">
				<?php if (isset($erro_nome)) echo "<p class='text-danger'>$erro_nome</p>";?>
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-6">
				<input type="email" class="form-control" id="email" name="email" placeholder="examplo@dominio.com.br" value="">
				<?php if (isset($erro_email)) echo "<p class='text-danger'>$erro_email</p>";?>
			</div>
		</div>
		<div class="form-group">
			<label for="mensagem" class="col-sm-2 control-label">Mensagem</label>
			<div class="col-sm-10">
				<textarea class="form-control" rows="4" name="mensagem"></textarea>
				<?php if (isset($erro_mensagem)) echo "<p class='text-danger'>$erro_mensagem</p>";?>
			</div>
		</div>
		<div class="form-group">
			<label for="human" class="col-sm-2 control-label">2 + 3 = ?</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="humano" name="humano" placeholder="Sua resposta">
				<?php if (isset($erro_humano)) echo "<p class='text-danger'>$erro_humano</p>";?>
			</div>
		</div>
		<div class="form-group">
		<div class="col-sm-2">
			</div>
			<div class="col-sm-10">
				<div class="g-recaptcha" data-sitekey="6LfzAaYUAAAAABauyhGhAiWeVwfwxn6zOoNi-Hwj"></div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<input id="enviar" name="btnsubmit" type="submit" value="Mandar mensagem" class="btn btn-primary">
			</div>
		</div>
		<input type="text" name="website" id="website" class="naomostra">
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
			<?php if (isset($submit)) echo "<p class='text-danger'>$submit</p>";?>
			</div>
		</div>
	</form>
</div>
