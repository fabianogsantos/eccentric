<?php
	include '../conecta.php';
	include '../funcoes.php';
	$callsign = $_POST['callsign'];
	echo "<br>";

	//	----------------------
	//   POSTO
	//	----------------------
	$t = br2ansi(date("d/m/Y",time()));
	// 1. Apaga todos os registros relativos ao piloto
	$sql = "delete from piloto_promocao where callsign = $callsign";
	$res = $con->query($sql);	
	if ($_POST['data_promocao']){
		// 2. Salva os dados atuais
		foreach ( $_POST['data_promocao'] as $k=> $c){
			$c = br2ansi($c);
			$sql = "insert into piloto_promocao (callsign, cod_promocao,data_promocao) values ($callsign,$k+1, '$c')";
			$res = $con->query($sql);
		}
		//atualiza o posto do piloto
		$sql_ = "update piloto set cod_posto=(select max(cod_promocao) from piloto_promocao where callsign=$callsign and data_promocao <> '0000-00-00') where callsign = \"$callsign\"";
		$res_ = $con->query($sql_);
	}	
	$sql_ = "update dossie_piloto set ultima_alt_dossie='$t' where callsign = \"$callsign\"";
	$res_ = $con->query($sql_);	

	//	----------------------
	//   PASSAPORTE
	//	----------------------
	// 1. Apaga todos os registros relativos ao piloto de PILOTO_PAIS

	$sql = "delete from piloto_pais where callsign = $callsign";
	$res = $con->query($sql);	

	if ($_POST['chk_passaporte']){
		// 2. Salva os dados atuais
		foreach ( $_POST['chk_passaporte'] as $k=> $c){
			$sql = "insert into piloto_pais (callsign, cod_pais) values ($callsign, $c)";
			$res = $con->query($sql);
		}
	}

	//	---------------------
	//   VOOS FRETADOS
	//	----------------------
	// 1. Apaga todos os registros relativos ao piloto de PILOTO_PAIS
	$sql = "delete from piloto_vf where callsign = $callsign";
	$res = $con->query($sql);
	if ($_POST['chk_vf']){
		// 2. Salva os dados atuais
		foreach ( $_POST['chk_vf'] as $k=> $c){
			$sql = "insert into piloto_vf (callsign, cod_vf) values ($callsign, $c)";
			$res = $con->query($sql);
		}	
	}

	//	----------------------
	//   VOOS HUMANIT�RIOS
	//	----------------------
	// 1. Apaga todos os registros relativos ao piloto de PILOTO_PAIS
	$sql = "delete from piloto_vh where callsign = $callsign";
	$res = $con->query($sql);
	if ($_POST['chk_vh']){
		// 2. Salva os dados atuais
		foreach ( $_POST['chk_vh'] as $k=> $c){
			$sql = "insert into piloto_vh (callsign, cod_vh) values ($callsign, $c)";
			$res = $con->query($sql);
		}
	}

	//	----------------------
	//   MISSOES ESPECIAIS
	//	----------------------
	// 1. Apaga todos os registros relativos ao piloto de PILOTO_PAIS
	$sql = "delete from piloto_me where callsign = $callsign";
	$res = $con->query($sql);
	if ($_POST['chk_me']){			
		// 2. Salva os dados atuais
		foreach ( $_POST['chk_me'] as $k=> $c){
			$sql = "insert into piloto_me (callsign, cod_me) values ($callsign, $c)";
			$res = $con->query($sql);
		}	
	}

	
	//	----------------------
	//   ESTAT�STICAS
	//	----------------------
	//se nao existe lancto para o piloto, gera um registro para ele
	$sql = "select callsign from dossie_piloto where callsign = $callsign";
	$res = $con->query($sql);

	if ($res->num_rows==0){
		$sql = "insert into dossie_piloto (callsign) values($callsign)";
		$res = $con->query($sql);
	}
	$reg =  $_POST['qtd_horas_voo'] ;
	$sql = "update dossie_piloto set qtd_horas_voo ='$reg' where callsign = '$callsign'";
	$res = $con->query($sql);
	$reg = $reg/100;
	$reg = floor($reg);
	$sql = "update dossie_piloto set qtd_estrelas = '$reg' where callsign = '$callsign'";		
	$res = $con->query($sql);	
	
	//estrelas de ouro
	$tempo_voo_online = soma_horas($_POST['tempovoovatsim'],$_POST['tempovooivao']);
	$tempo_voo_online = soma_horas($tempo_voo_online,$_POST['tempovoooutras']);
	$str = explode(":",$tempo_voo_online);
	$qtd_estrelas_ouro =  floor($str[0]/100);

	
	if($qtd_estrelas_ouro>10){
		$qtd_diplomas = floor($qtd_estrelas_ouro/10);
		$sql = "update dossie_piloto set qtd_diploma_estrela_ouro = $qtd_diplomas where callsign = '$callsign'";
		$res = $con->query($sql);
	}
	else {
		$qtd_diplomas = 0;
		$sql = "update dossie_piloto set qtd_diploma_estrela_ouro = $qtd_diplomas where callsign = '$callsign'";
		$res = $con->query($sql);		
	}
	$sql = "update dossie_piloto set qtd_estrela_ouro = $qtd_estrelas_ouro where callsign = '$callsign'";
	$res = $con->query($sql);
	$reg = $_POST['qtd_voos_ae_desat'];
	$sql = "update dossie_piloto set qtd_voos_ae_desat =	'$reg' where callsign = '$callsign'";
	$res = $con->query($sql);		
	$reg = $_POST['tempovoo_antes_ago2006'];
	$sql = "update dossie_piloto set tempovoo_antes_ago2006 =	'$reg' where callsign = '$callsign'";	
	$res = $con->query($sql);		
	$qtd_voo_ae_desat = $reg;
	$reg = 	$_POST['qtd_voos'];
	$qtd_voos = $reg;

	$sql = "update dossie_piloto set qtd_voos = $qtd_voos where callsign = '$callsign'";
	$res = $con->query($sql);
	$reg = 	$_POST['qtd_op'];

	$sql = "update dossie_piloto set 	qtd_op	=	$reg where callsign = '$callsign'";		
	$res = $con->query($sql);
	$reg = $_POST['ultimos_voos'];

	$sql = "update dossie_piloto set ultimos_voos =	'$reg' where callsign = '$callsign'";		
	$res = $con->query($sql);
	$reg = $_POST['data_ultimo_voo'];

	$reg = br2ansi($reg);
	$sql = "update dossie_piloto set data_ult_voo = '$reg' where callsign = '$callsign'";		
	$res = $con->query($sql);
	//conta VH
	$sql = "select count(callsign) qtd from piloto_vh where callsign = '$callsign'";
	$res = $con->query($sql);
	$arr_qtd_vh = $res->fetch_assoc();
	$qtd_vh = $arr_qtd_vh["qtd"];

	$sql = "update dossie_piloto set qtd_vh = $qtd_vh where callsign = '$callsign'";		
	$res = $con->query($sql);

	//conta VF
	$sql = "select count(callsign) qtd from piloto_vf where callsign = '$callsign'";
	$res = $con->query($sql);
	$arr_qtd_vf = $res->fetch_assoc();
	$qtd_vf = $arr_qtd_vf["qtd"];

	$sql = "update dossie_piloto set qtd_vf  = $qtd_vf where callsign = '$callsign'";	
	$res = $con->query($sql);	
	
	//conta me
	$sql = "select count(callsign) qtd from piloto_me where callsign = '$callsign'";
	$res = $con->query($sql);
	$arr_qtd_me = $res->fetch_assoc();
	$qtd_me = $arr_qtd_vf["qtd"];

	$sql = "update dossie_piloto set qtd_me  = $qtd_me where callsign = '$callsign'";		
	$res = $con->query($sql);		


	// Numero de voos nas aeronaves
	// 1. Apaga todos os registros relativos ao piloto 
	$sql = "delete from piloto_aeronave where callsign = $callsign";
	$res = $con->query($sql);

	$sql_aero = "select cod_aeronave from aeronave order by cod_aeronave";
	$res_aero = $con->query($sql_aero);

	if ($_POST['num_voos_aeronave']){		
		// 2. Salva os dados atuais
		$i=0;
		foreach ( $_POST['num_voos_aeronave'] as $k=> $c){
			$row = $res_aero->fetch_assoc();
			$cod_aeronave = $row["cod_aeronave"];
			$sql = "insert into piloto_aeronave (callsign, cod_aeronave,qtd_voos) values ($callsign, $cod_aeronave, $c)";
			$res = $con->query($sql);
		}	
	}

	//	----------------------
	//   CERTIFICADOS
	//	----------------------
	// 1. Apaga todos os registros relativos ao piloto
	$sql = "delete from piloto_certificado where callsign = $callsign";
	$res = $con->query($sql);	
	if ($_POST['chk_certificado']){
		// 2. Salva os dados atuais
		foreach ( $_POST['chk_certificado'] as $k=> $c){
			$sql = "insert into piloto_certificado (callsign, cod_certificado) values ($callsign, $c)";
			$res = $con->query($sql);
		}		
	}

	//	----------------------
	//   QUALIFICA��ES OPERACIONAIS
	//	----------------------
	//Instrutor
	// 1. Apaga todos os registros relativos ao piloto
	$sql = "delete from piloto_qo where callsign = $callsign";
	$res = $con->query($sql);
	$sql_aero = "select cod_aeronave from aeronave order by cod_aeronave";
	$res_aero = $con->query($sql_aero);

	if ($_POST['data_instrucao']){			
		// 2. Salva os dados atuais
		$i=0;
		foreach ( $_POST['data_instrucao'] as $k=> $c){
			$row = $res_aero->fetch_assoc();
			$cod_aeronave = $row["cod_aeronave"];
			$sql = "insert into piloto_qo (callsign, cod_aeronave,data_qo, tipo_qo) values ($callsign, $cod_aeronave,'".br2ansi($c)."','i')";			
			$res = $con->query($sql);
		}	
	}

	//IComandante mor
	$sql_aero = "select cod_aeronave from aeronave order by cod_aeronave";
	$res_aero = $con->query($sql_aero);

	if ($_POST['data_cmtemor']){			
		// 2. Salva os dados atuais
		$i=0;

		foreach ( $_POST['data_cmtemor'] as $k=> $c){
			$row = $res_aero->fetch_assoc();
			$cod_aeronave = $row["cod_aeronave"];
			$sql = "insert into piloto_qo (callsign, cod_aeronave,data_qo, tipo_qo) values ($callsign, $cod_aeronave,'".br2ansi($c)."','c')";
			$res = $con->query($sql);
		}	
	}	

	//	----------------------
	//   EVENTOS ON LINE
	//	----------------------
	// 1. Apaga todos os registros relativos ao piloto de eventos on line
	$sql = "delete from piloto_evento where callsign = $callsign";
	$res = $con->query($sql);
	if ($_POST['chk_evento']){
		// 2. Salva os dados atuais
		foreach ( $_POST['chk_evento'] as $k=> $c){
			$sql = "insert into piloto_evento (callsign, cod_evento) values ($callsign, $c)";
			$res = $con->query($sql);
		}
	}

	//	----------------------
	//   Voos multiplayer
	//	----------------------
	// 1. Apaga todos os registros relativos ao piloto de eventos on line
	$sql = "delete from piloto_mp where callsign = $callsign";
	$res = $con->query($sql);
	if ($_POST['chk_mp']){
		// 2. Salva os dados atuais
		foreach ( $_POST['chk_mp'] as $k=> $c){
			$sql = "insert into piloto_mp (callsign, cod) values ($callsign, $c)";
			$res = $con->query($sql);
		}
	}

	//	----------------------
	//   CARGO
	//	----------------------
	// 1. Apaga todos os registros relativos ao piloto de eventos on line
	$sql = "delete from piloto_cargo where callsign = $callsign";
	$res = $con->query($sql);
	if ($_POST['chk_cargo']){
		// 2. Salva os dados atuais
		foreach ( $_POST['chk_cargo'] as $k=> $c){
			$sql = "insert into piloto_cargo (callsign, cod_cargo) values ($callsign, $c)";
			$res = $con->query($sql);
		}
	}	

	// --------------------------------------	
	// VOOS ONLINE
	// --------------------------------------
	$qtdvoosivao = $_POST['qtdvoosivao'];
	$qtdvoosvatsim = $_POST['qtdvoosvatsim'];
	$qtdvoosoutras = $_POST['qtdvoosoutras'];	
	$qtdvoosoffline = $_POST['qtdvoosoffline'];
	$tempovooivao = $_POST['tempovooivao'];
	$tempovoovatsim = $_POST['tempovoovatsim'];
	$tempovoooutras = $_POST['tempovoooutras'];
	$tempovoooffline = $_POST['tempovoooffline'];	
	
	$sql = "update dossie_piloto set qtdvoosivao = $qtdvoosivao,
									qtdvoosvatsim = $qtdvoosvatsim,
									qtdvoosoutras = $qtdvoosoutras,
									qtdvoosoffline = $qtdvoosoffline,
									tempovooivao = '$tempovooivao',
									tempovoovatsim= '$tempovoovatsim',
									tempovoooutras = '$tempovoooutras',
									tempovoooffline = '$tempovoooffline'
			where callsign = $callsign";
	$res = $con->query($sql);			
?>
<script language="Javascript">
<!--
window.open('index.php?pagina=adm_pilotos','_parent')
//-->
</script>



