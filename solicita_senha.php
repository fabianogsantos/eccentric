<?
	include ('conecta.php');
	include('funcoes.php');
	$callsign = $_POST["callsign"];
	$dataNasc = $_POST["dataNasc"];
	
	$data = br2ansi($dataNasc);
		
	$sql = "select * from piloto where callsign = $callsign and status='a' and data_nasc ='$data'";
	$res = mysql_query($sql);
	$num = mysql_num_rows($res);
		
	if ($num>0){		
		$row = @mysql_fetch_assoc($res);
			
		//fazer rotina de valida��o da data
			
		$eccentric = "Eccentric Travels";	
		$eccentric_mail = " ";		
		$senha = geraSenha();
		$data_solic = Date("d/m/y");			
		$assunto = "Eccentric Travels - Solicita��o de Nova Senha";
		$mensagem = "Prezado Comandante, conforme sua solicita��o em $data_solic, sua nova senha para acesso ao site da Eccentric � $senha. A senha � sens�vel a mai�sculas e min�sculas. Voc� pode alter�-la, fazendo o login no site e usando a op��o Alterar Dados.";
		$email_piloto = $row["email"];	
		if(mail($email_piloto, $assunto, $mensagem, "From: $eccentric <$eccentric_mail>")){
			?><script language="Javascript">
			<!--
				window.open("index.php?pagina=sucesso_senha","_self");
			//-->
			</script><?	
			$sql = "update piloto set senha='$senha' where callsign = $callsign";
			$res = mysql_query($sql);	
			exit;				
		}
	}
	else {
		?>
		<script language="Javascript">
			alert("Erro na solicita��o de senha. Poss�veis motivos: \n- O callsign n�o existe\n- A data de nascimento n�o confere\n- O callsign informado � de um piloto inativo\n\nEntre em contato conosco.");
			window.open("index.php?pagina=frm_solicita_senha","_self");
		</script>  
		<?			
	}			
?>