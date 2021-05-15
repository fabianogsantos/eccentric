<?php
	$sql = "select * from relatorios where status = 1";
	$result = $con->query($sql);
	$qtd = $result->num_rows;

	if ($qtd == 0)
		echo "<p>N&atilde;o existem relat&oacute;rios aguardando.</p>";
	else
		echo "<p>Existem ".$qtd." relat&oacute;rios aguardando.</p>";

	$sql = "select * from op where status = 'p'";
	$result = $con->query($sql);
	$qtd = $result->num_rows;

	if ($qtd == 0)
		echo "<p>N&atilde;o existem OPs aguardando.</p>";
	else
		echo "<p>Existem ".$qtd." OPs aguardando.</p>";

	$sql = "select * from op where status = 'a'";
	$result = $con->query($sql);
	$qtd = $result->num_rows;

	if ($qtd == 0)
		echo "<p>N&atilde;o existem OPs em andamento.</p>";
	else
		echo "<p>Existem ".$qtd." OPs em andamento.</p>";

	$sql = "select * from candidato where status = 1";
	$result = $con->query($sql);
	$qtd = $result->num_rows;

	if ($qtd == 0)
		echo "<p>N&atilde;o existem candidatos aguardando.</p>";
	else
		echo "<p>Existem ".$qtd." candidatos aguardando.</p>";

	$sql = "select count(*) as qtd from livro_visitas where respondido=0";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();

	if($row['qtd']<=0){
			echo "<p>Livro de visitas está vazio.</p>";
	}
	else {
		if($row==1){
				echo "<p>Há 1 mensagem no livro de visitas.</p>";
		}
		else {
			echo "<p>Existem ".$row['qtd']." novas mensagens no livro de visitas.</p>";
		}
	}
?>
