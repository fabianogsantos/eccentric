<?php 
	if(!isset($_SESSION["callsign"])){
		?><script language="Javascript">
				window.open("index.php","_parent");
		</script><?php
    	exit;
	}
	setlocale(LC_CTYPE,"\\pt_BR\\");
	$p_callsign = $_GET["callsign"];
?>

<h2>Administra&ccedil;&atilde;o de dossi&ecirc;s</h2>
<form name="frm_dados" method="post" action="trata_dossie.php">
  <fieldset>
  <legend>Dados</legend>  	
	<?php
		$sql = "select * from piloto where callsign = $p_callsign";
		$res = $con->query($sql);
		@$row = $res->fetch_assoc();
		$callsign = $row['callsign'];
		$cod_posto = $row['cod_posto'];
    	echo "Callsign: ".$row["callsign"]."<br/>";
		echo "Nome Guerra: ".utf8_encode($row["nome_guerra"])."<br/>";
		$sql = "select ultima_alt_dossie from dossie_piloto where callsign = $p_callsign";
		$res = $con->query($sql);
		@$row = $res->fetch_assoc();		
		echo "&Uacute;ltima altera&ccedil;&atilde;o: ".ansi2br($row["ultima_alt_dossie"])."<br>";
    ?>
</fieldset>

<br>	
 <fieldset>
 <legend>Promo&ccedil;&otilde;es</legend>
  <?php
  // --------------------------------------------------------------------------------------------------------------------------------
  //  PROMOÇÕES
  // --------------------------------------------------------------------------------------------------------------------------------
  	$sql_lista_postos = "select * from posto order by cod_posto";
	$res_lista_postos = $con->query($sql_lista_postos);
	//busca quais postos possuem data de promocao
	echo "<table>";
	echo "<tr><td><font size=\"1\"><strong>Posto</strong></font></td>
	          <td><font size=\"1\"><strong>Data promo&ccedil;&atilde;o</strong></font></td>";

	while ($row_lista_postos = $res_lista_postos->fetch_assoc()){ //monta a lista dos postos e datas
		//verifica se existe uma data de promocao para o posto em questao
		$cod_posto = $row_lista_postos['cod_posto'];
		$sql_datas = "select * from piloto_promocao where callsign = $p_callsign and cod_promocao=$cod_posto and data_promocao<>'0000-00-00'";
		$res_datas = $con->query($sql_datas);
		if($res_datas->num_rows>0){ // achou uma data de promocao para o posto
			$row_data_promocao = $res_datas->fetch_assoc();
			$data_promocao = ansi2br($row_data_promocao['data_promocao']);
			echo "<tr><td><font size=\"1\">".$row_lista_postos["nome_posto"]."</font></td>";			
			echo "<td><input type=\"text\" name = \"data_promocao[]\" value=\"".$data_promocao."\" size=\"10\"></td></tr>";			
		}
		else {
			$data_promocao = "";
			echo "<tr><td><font size=\"1\">".$row_lista_postos["nome_posto"]."</font></td>";			
			echo "<td><input type=\"text\" name = \"data_promocao[]\" value=\"".$data_promocao."\" size=\"10\"></td></tr>";					
		}		
	}
	echo "</table>";
	echo "<br><input type=\"submit\" name=\"Submit3\" value=\"Altera\" class=\"botao\"><br>";
	echo "Ao inserir a data em um determinado posto, o piloto ser&aacute; promovido. Por&eacute;m &eacute; necess&aacute;rio clicar em Altera antes de inserir os outros dados do piloto.<br>";	
?>
  </fieldset><br> 
  <!-- **************************************
       VOOS ONLINE E ESTRELAS DE OURO
       ************************************** -->
  <?php
  	$sqlvo = "select * from dossie_piloto where callsign = $p_callsign";
	$resvo = $con->query($sqlvo);
	$rowvo = $resvo->fetch_assoc();	
	$qtdvoosivao = $rowvo['qtdvoosivao'];
	$qtdvoosoffline = $rowvo['qtdvoosoffline'];
	$qtdvoosvatsim = $rowvo['qtdvoosvatsim'];
	$qtdvoosoutras = $rowvo['qtdvoosoutras'];
	$tempovooivao = $rowvo['tempovooivao'];
	$tempovoovatsim = $rowvo['tempovoovatsim'];
	$tempovoooutras = $rowvo['tempovoooutras'];
	$tempovoooffline = $rowvo['tempovoooffline'];
	$qtdvoostotal = $qtdvoosivao+$qtdvoosvatsim+$qtdvoosoutras;
    $tempo1 = soma_horas($tempovooivao, $tempovoovatsim);
	$tempo1 = soma_horas($tempovoooutras, $tempo1);
  ?>
  <fieldset><legend>&nbsp;Voos online&nbsp;</legend>
  <br />

  <table border="1" align="center" >
	<tr><th>&nbsp;</th><th>Offline</th>
	  <th>Vatsim</th><th>Ivao</th><th>Outras</th><th>Total Online</th></tr>
	<tr><th>Qtd Voos</th>
    <td align="center"><input name="qtdvoosoffline" type="text" id="qtdvoosoffline" value="<?php echo $qtdvoosoffline; ?>" size="5" maxlength="5"/></td>
    <td align="center"><input name="qtdvoosvatsim" type="text" id="qtdvoosvatsim" value="<?php echo $qtdvoosvatsim; ?>" size="5" maxlength="5"/></td>
	<td align="center"><input name="qtdvoosivao" type="text" id="qtdvoosivao" value="<?php echo $qtdvoosivao; ?>" size="5" maxlength="5"/></td>		            
	<td align="center"><input name="qtdvoosoutras" type="text" id="qtdvoosoutras" value="<?php echo $qtdvoosoutras; ?>" size="5" maxlength="5"/></td>
	<td align="center"><?php echo $qtdvoostotal; ?></td>    </tr>
    <tr>

	<tr><th>Tempo Voo</th>    

    <td align="center"><input name="tempovoooffline" type="text" id="tempovoooffline" value="<?php echo $tempovoooffline; ?>" size="7" maxlength="7" /></td>

    <td align="center"><input name="tempovoovatsim" type="text" id="tempovoovatsim" value="<?php echo $tempovoovatsim; ?>" size="7" maxlength="7" /></td>

    <td align="center"><input name="tempovooivao" type="text" id="tempovooivao" value="<?php echo $tempovooivao; ?>" size="7" maxlength="7" /></td>

    <td align="center"><input name="tempovoooutras" type="text" id="tempovoooutras" value="<?php echo $tempovoooutras; ?>" size="7" maxlength="7"/></td>

    <td align="center"><?php echo $tempo1; ?></td>

    </tr>    

  </table>

  <p>Preencha com zeros os valores acima quando n&atilde;o conhecidos. N&atilde;o deixe em branco.</p>

  </fieldset>



 <fieldset>
  <legend>&nbsp;Estat&iacute;sticas Gerais&nbsp;</legend>
  <br />

   

  <?php

  // -------------------------------------------------------------------------------------
  // ESTATÍSTICAS GERAIS
  // -------------------------------------------------------------------------------------    

  	$sql = "select * from dossie_piloto where callsign = (select callsign from piloto where  callsign = \"$p_callsign\")";
  	$res = $con->query($sql);
	$row = $res->fetch_assoc();

	$sql_num_vf = "select count(callsign) as qtd from piloto_vf where callsign = \"$p_callsign\"";
	$res_num_vf = $con->query($sql_num_vf);
	$num_vf = $res_num_vf->fetch_assoc()['qtd'];

	$sql_num_vh = "select count(callsign) as qtd  from piloto_vh where callsign = \"$p_callsign\"";
	$res_num_vh = $con->query($sql_num_vh);
	$num_vh = $res_num_vh->fetch_assoc()['qtd'];

	$sql_num_voo = "select sum(qtd_voos) as qtd  from piloto_aeronave where callsign = \"$p_callsign\"";
	$res_num_voo = $con->query($sql_num_voo);
	$num_voos = $res_num_voo->fetch_assoc()['qtd'];

	$num_voos = $num_voos + $row["qtd_voos_ae_desat"];
?>

    <table border="1" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td>Voos efetuados na companhia (autom&aacute;tico)</td>
        <td><?php  echo "<input type=\"text\" name = \"qtd_voos\" value=\"".$num_voos."\" size=\"4\">"; ?> </td>
      </tr>
      <tr>
        <td>Ordens de Opera&ccedil;&atilde;o</td>
        <td><?php echo "<input type=\"text\" name = \"qtd_op\" value=\"".$row["qtd_op"]."\" size=\"4\">"; ?></td>
      </tr>
      <tr>
        <td>Data do &uacute;ltimo voo</td>
        <td><?php echo "<input type=\"text\" name = \"data_ultimo_voo\" value=\"".ansi2br($row["data_ult_voo"])."\" size=\"10\">"; ?></td>
      </tr>
      <tr>
        <td>&Uacute;ltimos voos</td>
        <td><?php echo "<input type=\"text\" name = \"ultimos_voos\" value=\"".$row["ultimos_voos"]."\" size=\"30\">"; ?></td>
      </tr>      <tr>
        <td>Quantidade de voos em aeronaves desativadas</td>
        <td><?php echo "<input type=\"text\" name = \"qtd_voos_ae_desat\" value=\"".$row["qtd_voos_ae_desat"]."\" size=\"3\">"; ?></td>
      </tr>      

      <tr>
        <td>Total de horas at&eacute; 10/08/06</td>
        <td><?php echo "<input type=\"text\" name = \"tempovoo_antes_ago2006\" value=\"".($row["tempovoo_antes_ago2006"])."\" size=\"10\">"; ?></td>
      </tr>      
      <tr>
      	<td>Horas de voo (hhhh:mm) </td>
        <?php 
			$tempovoooffline = $row['tempovoooffline'];
			$tempovoovatsim=$row['tempovoovatsim'];
			$tempovooivao = $row['tempovooivao'];
			$tempovoooutras = $row['tempovoooutras'];	
			$tempovoo_antes_ago2006 = $row['tempovoo_antes_ago2006'];
			$qtd_horas_voo = soma_horas($tempovoooffline,$tempovoooutras);
			$qtd_horas_voo = soma_horas($qtd_horas_voo,$tempovoovatsim);
			$qtd_horas_voo = soma_horas($qtd_horas_voo,$tempovooivao);	
			$tempovoototal = soma_horas($qtd_horas_voo,$tempovoo_antes_ago2006);
		?>
        <td><?php 	echo "<input type=\"text\" name = \"qtd_horas_voo\" value=\"".$tempovoototal."\" size=\"8\">"; ?></td>
        </tr>      

      <tr>
      <td>Total de horas </td>
      <td><?php echo $tempovoototal; ?></td>
    </table>
    <br />
</fieldset>
  

    <fieldset><legend>Passaporte </legend>

  <?php
  	$sql = "select * from pais order by nome";
	$res = $con->query($sql);

	$sql2 = "select cod_pais from piloto_pais where callsign = (select callsign from piloto where callsign = \"$p_callsign\")";
	$res2 = $con->query($sql2);

	echo "<input type = hidden name=\"callsign\" value=\"".$p_callsign."\">"; 
	$vetor = array();

	while ($row2 =$res2->fetch_assoc()){
		$vetor[] = $row2["cod_pais"];	
	}

	echo "<table border=0><tr>";
	$col = 1;
	$num = 0;

	
	while ($row=$res->fetch_assoc()){
		$valor1=$row["cod_pais"];
		if (in_array($valor1,$vetor )){
			echo "<td><font size=\"1\"><input type=\"checkbox\" name=\"chk_passaporte[]\" value=\"".$valor1."\" checked>".utf8_encode($row["nome"])."</font></td>";	
		}
		else{
			echo "<td><font size=\"-5\"><input type=\"checkbox\" name=\"chk_passaporte[]\" value=\"".$valor1."\" >".utf8_encode($row["nome"])."</font></td>";			
		}	

		$col++;
		if ($col>4){
			$col=1;
			echo"</tr><tr>";
		}			
	}
	echo "</tr></table>";

	$sql_num_bandeiras = "select count(callsign) as qtd from piloto_pais where callsign = \"$p_callsign\"";
	$res_num_bandeiras = $con->query($sql_num_bandeiras);
	$num_bandeiras = $res_num_bandeiras->fetch_assoc()['qtd'];
	echo "N&uacute;mero de pa&iacute;ses que o piloto j&aacute; pousou: ".$num_bandeiras;
  ?>
  </fieldset>

  <fieldset>
  <legend>V&ocirc;os Fretados</legend>
  <?php
  	$sql = "select * from vf order by des_vf";
	$res = $con->query($sql);
	
	$sql2 = "select cod_vf from piloto_vf where callsign = (select callsign from piloto where callsign = \"$p_callsign\")";
	$res2 = $con->query($sql2);
	$vetor = array();
	
	while ($row2 =$res2->fetch_assoc()){
		$vetor[] = $row2["cod_vf"];	
	}

	
	while ($row=$res->fetch_assoc()){
		$valor1 = $row["cod_vf"];
		if (in_array($valor1,$vetor )){
			echo "<input type=\"checkbox\" name=\"chk_vf[]\" value=\"".$valor1."\" checked>".utf8_encode($row["des_vf"])." - (".$row['imagem'].")<br/>";	
		}
		else{
			echo "<input type=\"checkbox\" name=\"chk_vf[]\" value=\"".$valor1."\" >".utf8_encode($row["des_vf"])." - (".$row['imagem'].")<br/>";
		}
	}	
  ?>
  </fieldset>
  <br>

  <fieldset> 
  <legend>V&ocirc;os Humanit&aacute;rios</legend>
  <?php
  	$sql = "select * from vh order by des_vh";
	$res = $con->query($sql);

	$sql2 = "select cod_vh from piloto_vh where callsign = (select callsign from piloto where callsign = \"$p_callsign\")";
	$res2 = $con->query($sql2);

	$vetor = array();
	while ($row2 =$res2->fetch_assoc()){
		$vetor[] = $row2["cod_vh"];	
	}

	while ($row=$res->fetch_assoc()){
		$valor1 = $row["cod_vh"];
		if (in_array($valor1,$vetor )){
			echo "<input type=\"checkbox\" name=\"chk_vh[]\" value=\"".$valor1."\" checked>".utf8_encode($row["des_vh"])." - (".$row['imagem'].")<br/>";	
		}
		else{
			echo "<input type=\"checkbox\" name=\"chk_vh[]\" value=\"".$valor1."\" >".utf8_encode($row["des_vh"])." - (".$row['imagem'].")<br/>";
		}			
	}	
  ?>
  </fieldset>

  <br>

  <fieldset>

  <legend>Miss&otilde;es Especiais</legend>

  <?php
  	$sql = "select * from me order by nome";
	$res = $con->query($sql);

	$sql2 = "select cod_me from piloto_me where callsign = (select callsign from piloto where callsign = \"$p_callsign\")";
	$res2 = $con->query($sql2);
	$vetor = array();

	//monta um vetor com somente as me's que o piloto participo
	while ($row2 =$res2->fetch_assoc()){
		$vetor[] = $row2["cod_me"];	
	}
	
	while ($row=$res->fetch_assoc()){
		$valor1 = $row["cod"];
		if (in_array($valor1,$vetor )){
			echo "<input type=\"checkbox\" name=\"chk_me[]\" value=\"".$valor1."\" checked>".utf8_encode($row["nome"])." - (".$row['imagem'].")<br/>";	
		}
		else{
			echo "<input type=\"checkbox\" name=\"chk_me[]\" value=\"".$valor1."\" >".utf8_encode($row["nome"])." - (".$row['imagem'].")<br/>";
		}	
	}			
  ?>
  </fieldset><br>

<?php		
  // -------------------------------------------------------------------------------------
  // DADOS SOBRE AERONAVES
  // ------------------------------------------------------------------------------------- 	
	echo "</fieldset><br><fieldset><legend>Dados sobre aeronaves</legend>";	
	echo "<table border=\"1\" class=\"bordasimples\">";
	echo "<tr><td><font size=\"1\">Nro. Vôos</td>
		  <td><font size=\"1\">Dt. Instrutor</td>
		  <td><font size=\"1\">Dt. Cmte. Mor</td>
		  <td><font size=\"1\">Aeronave</td></tr>";

	$sql = "select * from aeronave order by cod_aeronave";
	$res = $con->query($sql);

	//verifica quais aeronaves o piloto ja voou
	$sql_ae = "select * from piloto_aeronave where callsign = \"$p_callsign\" and qtd_voos>0";
	$res_ae = $con->query($sql_ae);
	$vet_ae = array();

	while ($row=$res_ae->fetch_assoc()){
		$vet_ae[]=$row["cod_aeronave"];
	}

	//monta a lista de aeronaves 
	while ($row_nome_ae =$res->fetch_assoc()){
		$cod_ae = $row_nome_ae["cod_aeronave"];
		if(in_array($cod_ae,$vet_ae)){ 
			//qtde de voos
			$sql_qtd_voos = "select qtd_voos from piloto_aeronave where callsign = $p_callsign and cod_aeronave = $cod_ae";
			$res_qtd_voos = $con->query($sql_qtd_voos);

			if($res_qtd_voos->num_rows>0){
				$num_voos = $res_qtd_voos->fetch_assoc()['qtd_voos'];
			}
			else {
				$num_voos = "";
			}				
		}
		else {
			$num_voos = ""; 
		}		

		if(in_array($cod_ae,$vet_ae)){ 
			//data de instrucao
			$sql_data_instrucao = "select data_qo from piloto_qo where callsign = \"$p_callsign\" and cod_aeronave = $cod_ae and tipo_qo='i'";
			$res_data_instrucao = $con->query($sql_data_instrucao);

			if($res_data_instrucao->num_rows>0){
				$row = $res_data_instrucao->fetch_assoc();
				$data_instrucao = ansi2br($row["data_qo"]);

				if ($data_instrucao == '00/00/0000') {
					$data_instrucao = "";
				}
			}
			else {
				$data_instrucao = ""; 
			}						
		}
		else {
			$data_instrucao = ""; 
		}	

		if(in_array($cod_ae,$vet_ae)){ 
			//data comandante mor
			$sql_data_cmtemor = "select data_qo from piloto_qo where callsign = \"$p_callsign\" and cod_aeronave = $cod_ae and tipo_qo='c'";
			$res_data_cmtemor = $con->query($sql_data_cmtemor);

			if($res_data_cmtemor->num_rows>0){
				$row = $res_data_cmtemor->fetch_assoc();

				$data_cmtemor = ansi2br($row["data_qo"]);
				if ($data_cmtemor == '00/00/0000') {
					$data_cmtemor = "";
				}
			}
			else {
				$data_cmtemor = ""; 
			}						
		}
		else {
			$data_cmtemor = ""; 
		}		
		echo "<tr>
		<td><font size=\"1\"><input type=\"text\" name=\"num_voos_aeronave[]\" value=\"".$num_voos."\" size=\"4\"></td>
		<td><font size=\"1\"><input type=\"text\" name=\"data_instrucao[]\" value=\"".$data_instrucao."\" size=\"10\"></td>
		<td><font size=\"1\"><input type=\"text\" name=\"data_cmtemor[]\" value=\"".$data_cmtemor."\" size=\"10\"></td>
		<td><font size=\"1\">".$row_nome_ae["nome"]."</td></tr>";					

	}

	echo "</table>";



//	echo "<input type=\"hidden\" name=\"callsign\" value=\"".$callsign."\">";

  ?>

  </fieldset>

  <fieldset><br>

  <legend>Certificados</legend>
  <?php
  	$sql = "select * from certificado order by des_certificado";
	$res = $con->query($sql);
	$sql2 = "select cod_certificado from piloto_certificado where callsign = (select callsign from piloto where callsign = \"$p_callsign\")";
	$res2 = $con->query($sql2);
	$vetor = array();

	while ($row2 =$res2->fetch_assoc()){
		$vetor[] = utf8_encode($row2["cod_certificado"]);	
	}
		
	while ($row=$res->fetch_assoc()){
		$valor1 = $row["cod_certificado"];

		if (in_array($valor1,$vetor )){
			echo "<input type=\"checkbox\" name=\"chk_certificado[]\" value=\"".$valor1."\" checked>".$row["des_certificado"]."<br/>";	
		}
		else{
			echo "<input type=\"checkbox\" name=\"chk_certificado[]\" value=\"".$valor1."\" >".$row["des_certificado"]."<br/>";
		}	
	}			
  ?>
  </fieldset><br>  

    <!-- EVENTOS ON LINE -->
 <fieldset>
  <legend>Eventos On Line</legend>
  <?php
  	$sql = "select * from evento order by des_evento";
	$res = $con->query($sql);
	$sql2 = "select cod_evento from piloto_evento where callsign = (select callsign from piloto where callsign = \"$p_callsign\")";
	$res2 = $con->query($sql2);
	$vetor = array();
	//monta um vetor com somente os eventos que o piloto participou
	while ($row2 =@$res2->fetch_assoc()){
		$vetor[] = $row2["cod_evento"];	
	}
	while ($row=@$res->fetch_assoc()){
		$valor1 = $row["cod_evento"];
		if (in_array($valor1,$vetor )){
			echo "<input type=\"checkbox\" name=\"chk_evento[]\" value=\"".$valor1."\" checked>".utf8_encode($row["des_evento"])."<br/>";	
		}
		else{
			echo "<input type=\"checkbox\" name=\"chk_evento[]\" value=\"".$valor1."\" >".utf8_encode($row["des_evento"])."<br/>";
		}	
	}			
  ?>
  </fieldset><br>    
  <fieldset>
  <legend>Voos Multiplayer</legend>
  <?php
  	$sql = "select * from mp order by nome";
	$res = $con->query($sql);
	$sql2 = "select cod from piloto_mp where callsign = (select callsign from piloto where callsign = \"$p_callsign\")";
	$res2 = $con->query($sql2);
	$vetor = array();
	//monta um vetor com somente os eventos que o piloto participou
	while ($row2 =@$res2->fetch_assoc()){
		$vetor[] = $row2["cod"];	
	}
	while ($row=@$res->fetch_assoc()){
		$valor1 = $row["cod"];
		if (in_array($valor1,$vetor )){
			echo "<input type=\"checkbox\" name=\"chk_mp[]\" value=\"".$valor1."\" checked>".utf8_encode($row["nome"])."<br/>";	
		}
		else{
			echo "<input type=\"checkbox\" name=\"chk_mp[]\" value=\"".$valor1."\" >".utf8_encode($row["nome"])."<br/>";
		}	
	}			
  ?>
  </fieldset><br>    
  <fieldset>

  <legend>Cargos</legend>
  <?php
  	$sql = "select * from cargo order by des_cargo";
	$res = $con->query($sql);

	$sql2 = "select cod_cargo from piloto_cargo where callsign = (select callsign from piloto where callsign = \"$p_callsign\")";
	$res2 = $con->query($sql2);
	$vetor = array();

	//monta um vetor com somente as me's que o piloto participou
	while ($row2 =$res2->fetch_assoc()){
		$vetor[] = $row2["cod_cargo"];	
	}

	while ($row=$res->fetch_assoc()){
		$valor1 = $row["cod_cargo"];
		if (in_array($valor1,$vetor )){
			echo "<input type=\"checkbox\" name=\"chk_cargo[]\" value=\"".$valor1."\" checked>".utf8_encode($row["des_cargo"])."<br/>";	
		}
		else{
			echo "<input type=\"checkbox\" name=\"chk_cargo[]\" value=\"".$valor1."\" >".utf8_encode($row["des_cargo"])."<br/>";
		}	
	}			
  ?>
  </fieldset><br> 
  <p> 
    <input type="submit" name="Submit3" value="Altera" class="botao">
  </p>
</form>