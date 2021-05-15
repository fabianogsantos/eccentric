<?
	$piloto = $_GET["piloto_callsign"];
	require_once("conecta.php"); 
//	include("funcoes.php");	
	function data_instrutor($data){
		$a = explode("-",$data);
		$b = $a[1]."/".$a[0];
		return ($b);	
	}

	$sql = "select * from piloto where callsign = $piloto";
	$res = mysql_query($sql);
	$row = @mysql_fetch_assoc($res); 
	$cod_posto = $row["cod_posto"];
	$nomeGuerra = $row["nome_guerra"];
	$data_ingresso = ansi2br($row["data_ingresso"]);
	$nucleo = $row["nucleo"];
	$cidade = utf8_encode($row["cidade"]);
	$uf = $row["uf"];
	$imagem = $row["imagem"];

	$sql = "select nome_nucleo from nucleo where sigla_nucleo = '$nucleo'";	
	$res = mysql_query($sql);
	$row = @mysql_fetch_assoc($res); 	
	$nucleo = $row["nome_nucleo"];
	
	$sql = "select * from dossie_piloto where callsign = $piloto";	
	$res = mysql_query($sql);
	$row = @mysql_fetch_assoc($res); 
	$qtd_horas_voo = $row["qtd_horas_voo"];
	$qtd_voos = $row["qtd_Voos"];
	$qtd_estrelas = $row["qtd_Estrelas"];
	$qtd_op = $row["qtd_op"];	
	$qtd_voos_ae_desat = $row["qtd_voos_ae_desat"];
	$ultima_alt_dossie = $row["ultima_alt_dossie"];
		
	$sql = "select * from piloto_vf where callsign = $piloto";
	$res = mysql_query($sql);
	$qtd_ch = mysql_num_rows($res);

	$sql = "select * from piloto_vh where callsign = $piloto";
	$res = mysql_query($sql);	
	$qtd_vh = mysql_num_rows($res);
	
	$sql = "select * from piloto_me where callsign = $piloto";
	$res = mysql_query($sql);		
	$qtd_me = mysql_num_rows($res);

	$sql = "select nome_posto from posto where cod_posto = $cod_posto";
	$res = mysql_query($sql);
	$row = @mysql_fetch_assoc($res);
		
	$nome_posto = $row["nome_posto"];

    echo "<h4 align=\"center\">".$nome_posto." - Cmte. ".$nomeGuerra."</h4><br>";
?>
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />

<div id="Accordion1" class="Accordion" tabindex="0">
  <div class="AccordionPanel">
    <div class="AccordionPanelTab">Informações do Piloto</div>
    <div class="AccordionPanelContent">
                <!--- INFORMAÇÕES -->
            <TABLE border="1">
                <TD><div align="right"><strong>Nome de Guerra: </strong></div></TD>
                <TD> <? echo $nomeGuerra ?> </TD>
                <TD rowspan="7">
                <? echo "<IMG src=\"".$dir_imagem_pilotos.$imagem."\" width=\"120\" height=\"150\">"; ?>	</TD>
              </TR>
              <TR>
                <TD><div align="right"><strong>Código Público/Callsign: </strong></div></TD>
                <TD>ETR-<? echo completazeros($piloto) ?></TD>
              </TR>
              <TR>
                <TD width=258><div align="right"><strong>Data de Ingresso: </strong></div></TD>
                <TD><? echo $data_ingresso ?></TD>
              </TR>
              <TR>
                <TD><div align="right"><strong>Núcleo de Operações: </strong></div></TD>
                <TD><? echo $nucleo ?></TD>
              </TR>
              <TR><TD><div align="right"><strong>Residência Atual: </strong></div></TD>
              <TD><? echo $cidade." - ".$uf ?></TD>
              </TR>
              <TR>
                <TD><div align="right"><strong>Aeronave Primária: </strong></div></TD>
                <?
                if ($cod_posto>'7'){
                    echo "<TD width=\"258\">Todos os modelos</TD></TR>";
                }		
                else {		
                    if ($nucleo=='Belo Horizonte'){
                        $sql_a = "select ae.nome, ae.nome_guerra from aeronave ae, piloto p where p.callsign = $piloto and flg_aeronave_primaria = '1' and p.cod_posto = ae.cod_posto and tipo_aeronave = 'c'";
                        $res_a = mysql_query($sql_a);
                        $row_a = @mysql_fetch_assoc($res_a);
                        $aeronave_primaria = $row_a["nome"];
                        echo "<TD>".$aeronave_primaria."</TD></TR>";
                    }
                    else {
                        $sql_a = "select ae.nome, ae.nome_guerra from aeronave ae, piloto p where p.callsign = $piloto and flg_aeronave_primaria = '1' and p.cod_posto = ae.cod_posto and tipo_aeronave in ('p','t')";
                        $res_a = mysql_query($sql_a);
                        $row_a = @mysql_fetch_assoc($res_a);
                        $aeronave_primaria = $row_a["nome"];		
                        echo "<TD>".$aeronave_primaria."</TD></TR>";
                    }			
                }		
            
                    $sql = "select des_cargo from cargo where cod_cargo in (select cod_cargo from piloto_cargo where callsign = $piloto)";
                    $res = mysql_query($sql);
                    $nlin = mysql_num_rows($res);
                    $i = 1;
                    
                    if ($nlin>0){
                        echo "<TR><TD valign='top'><div align=\"right\"><strong>Cargos Atuais: </strong></div></TD>";
                        echo "<TD width=\"258\">";
                        while ($row=mysql_fetch_assoc($res)){
                            echo "# ".$row["des_cargo"]."<br>";
                        }
                        echo "</TD></TR>";
                    }
                    echo "<TR><TD><div align=\"right\"><strong>Última alteração no dossiê: </strong></div></TD><TD colspan=\"2\">".ansi2br($ultima_alt_dossie)."</TD></TR>";		
                ?>
            </TABLE>
    </div>
  </div>
  <div class="AccordionPanel">
    <div class="AccordionPanelTab">Promoções</div>
    <div class="AccordionPanelContent">Content 2</div>
  </div>
</div>

<br>
	
<!-- -------------------------------------------------------------------------------------------
  PROMOCOES
  --------------------------------------------------------------------------------------------->	
<h4>Promoções</h4>
<TABLE>
  <TR>
<?
	$sql = "SELECT p.des_promocao, pp.data_promocao, p.imagem 
	        FROM promocao p, piloto_promocao pp 
			WHERE pp.callsign = $piloto 
			and pp.cod_promocao = p.cod_promocao
			and pp.data_promocao <> '0000-00-00'";
	$res = mysql_query($sql);
	$numlin = mysql_num_rows($res);
	
	if ($numlin > 0){
		while($row = mysql_fetch_assoc($res)){
			echo "<TR><TD><IMG src=\"".$row["imagem"]."\" width=\"20\" height=\"20\"></TD><TD width=\"496\"><DIV class=\"normaltext2\">".$row["des_promocao"]." em ".ansi2br($row["data_promocao"])."</TD></TR>";		
		}
	}
?>
</TABLE><br>

<!-- -------------------------------------------------------------------------------------------
  PASSAPORTE
  --------------------------------------------------------------------------------------------->
<h4>Eccentric Passport</h4>
<TABLE>
<?
	$sql = "select p.nome,p.imagem 
	        from pais p, piloto_pais pp 
			where p.cod_pais = pp.cod_pais 
			and pp.callsign = $piloto";
	$res = mysql_query($sql);
	$numlin = mysql_num_rows($res);
	$i = 0;
	echo "<tr>";
	while ($row = mysql_fetch_assoc($res)){
		if($i>=7){
			echo "</tr>";
			echo "<tr>";
			echo "<TD><IMG src=\"".$row["imagem"]."\" width=\"60\" height=\"28\" alt=\"".$row["nome"]."\" title=\"".$row["nome"]."\"></TD>";
			$i=1;
		}
		else{
			echo "<TD><IMG src=\"".$row["imagem"]."\" width=\"60\" height=\"28\" alt=\"".$row["nome"]."\" title=\"".$row["nome"]."\"></TD>";
			$i++;				
		}		
	}
	echo "</tr>";	
?>	
</TABLE><br>

<!-- -------------------------------------------------------------------------------------------
  VOOS FRETADOS
  --------------------------------------------------------------------------------------------->
<h4>Vôos Fretados</h4>
<TABLE align="center">
<?
	$sql = "select imagem from vf, piloto_vf pf where pf.cod_vf = vf.cod_vf and pf.callsign = $piloto";
	$res = mysql_query($sql);
	$numlin = @mysql_num_rows($res);
	$i = 0;
	echo "<tr>";
	while ($row = @mysql_fetch_assoc($res)){
		if($i>=2){
			echo "</tr>";
			echo "<tr>";
			echo "<TD><IMG src=\"".$dir_imagem_vf.$row["imagem"]."\" width=\"230\" height=\"132\"></TD>";			
			$i=1;
		}
		else{
			echo "<TD><IMG src=\"".$dir_imagem_vf.$row["imagem"]."\" width=\"230\" height=\"132\"></TD>";
			$i++;				
		}		
	}
	echo "</tr>";	
?>			
</TABLE><br>

<!-- -------------------------------------------------------------------------------------------
  VOOS HUMANITARIOS
  --------------------------------------------------------------------------------------------->
<h4>Vôos Humanitários</h4>
<TABLE align="center">
<?
	$sql = "select imagem from vh, piloto_vh ph where ph.cod_vh = vh.cod_vh and ph.callsign = $piloto";
	$res = mysql_query($sql);
	$numlin = @mysql_num_rows($res);
	$col = 1;
	echo "<tr>";
	while ($row = @mysql_fetch_assoc($res)){
		echo "<TD><IMG src=\"".$dir_imagem_vh.$row["imagem"]."\" width=\"230\" height=\"132\"></TD>";
		$col++;
		if($col>2){
			echo "</tr><tr>";
			$col=1;
		}			
	}
	echo "</tr>";	
?>			
</TABLE><br>

<!-- -------------------------------------------------------------------------------------------
  MISSOES ESPECIAIS
 ------------------------------------------------------------------------------------------- -->
<h4>Missões Especiais</h4>
<TABLE>
<?
	$sql = "select imagem from me, piloto_me pm where pm.cod_me = me.cod_me and pm.callsign = $piloto";
	$res = mysql_query($sql);
	$numlin = @mysql_num_rows($res);
	while ($row = @mysql_fetch_assoc($res)){
		echo "<tr><TD><IMG src=\"".$dir_imagem_me.$row["imagem"]."\" width='490'></TD></tr>";			
	}
	echo "</tr>";	
?>			
</TABLE><br>

<!-- -------------------------------------------------------------------------------------------
  ESTATÍSTICAS
 ------------------------------------------------------------------------------------------- -->
<h4>Estatísticas</h4>
<TABLE>
  <TR>
    <TD width="300">Horas de Vôo&nbsp;</TD>
    <? echo "<TD>".$qtd_horas_voo."</TD></TR>"; ?>
  <TR>
    <TD>Vôos efetuados na Companhia&nbsp;</TD>
    <? echo "<TD>".$qtd_voos."</TD></TR>"; ?>
  </Table>
  	
<h4>Transporte de Passageiros</h4>
<table>	
  
  	<?
		$sql = "select *
		from aeronave
		where tipo_aeronave = 'p' 
		order by cod_aeronave";
		$res = mysql_query($sql);

		while ($row=@mysql_fetch_assoc($res)){  //gera a lista de todas as aeronaves, por tipo
		
			$sql_pa = "select * 
						from  piloto_aeronave
						where callsign = $piloto";
			$res_pa = mysql_query($sql_pa);			//seleciona as aeronaves que o piloto ja voou

			
			$vet_pa = array();
			
			while($row_pa = mysql_fetch_assoc($res_pa)){
				$vet_pa[$row_pa['cod_aeronave']] = $row_pa['qtd_voos'];
			}
			$cod_aeronave_lista = $row['cod_aeronave'];
			if (array_key_exists($cod_aeronave_lista,$vet_pa)) {
				//echo "if. cod_aeronave_lista =".$cod_aeronave_lista."<br>";
				echo "<tr><TD width='300'>Vôos efetuados no ".$row["nome"]."</TD>";
				echo "<TD>".$vet_pa[$cod_aeronave_lista]."</TD></TR>";
			}
			else {
				//echo "cod_aeronave_lista =".$cod_aeronave_lista."<br>";
				echo "<tr><TD width='300'>Vôos efetuados no ".$row["nome"]."</TD>";
				echo "<TD>0</TD></TR>";			
			}
		}				
	?>
</table>
<h4>Transporte de Carga</h4>
<table>							
   	<?
		$sql = "select *
		from aeronave
		where tipo_aeronave = 'c' 
		order by cod_aeronave";
		$res = mysql_query($sql);

		while ($row=@mysql_fetch_assoc($res)){  //gera a lista de todas as aeronaves, por tipo
		
			$sql_pa = "select * 
						from  piloto_aeronave
						where callsign = $piloto";
			$res_pa = mysql_query($sql_pa);			//seleciona as aeronaves que o piloto ja voou

			
			$vet_pa = array();
			
			while($row_pa = mysql_fetch_assoc($res_pa)){
				$vet_pa[$row_pa['cod_aeronave']] = $row_pa['qtd_voos'];
			}
			$cod_aeronave_lista = $row['cod_aeronave'];
			if (array_key_exists($cod_aeronave_lista,$vet_pa)) {
				//echo "if. cod_aeronave_lista =".$cod_aeronave_lista."<br>";
				echo "<tr><TD width='300'>Vôos efetuados no ".$row["nome"]."</TD>";
				echo "<TD>".$vet_pa[$cod_aeronave_lista]."</TD></TR>";
			}
			else {
				//echo "cod_aeronave_lista =".$cod_aeronave_lista."<br>";
				echo "<tr><TD width='300'>Vôos efetuados no ".$row["nome"]."</TD>";
				echo "<TD>0</TD></TR>";			
			}
		}				
	?>
</table>
<h4>Táxi Aéreo</h4>
<table>
  	<?
		$sql = "select *
		from aeronave
		where tipo_aeronave = 't' 
		order by cod_aeronave";
		$res = mysql_query($sql);

		while ($row=@mysql_fetch_assoc($res)){  //gera a lista de todas as aeronaves, por tipo
		
			$sql_pa = "select * 
						from  piloto_aeronave
						where callsign = $piloto";
			$res_pa = mysql_query($sql_pa);			//seleciona as aeronaves que o piloto ja voou

			
			$vet_pa = array();
			
			while($row_pa = mysql_fetch_assoc($res_pa)){
				$vet_pa[$row_pa['cod_aeronave']] = $row_pa['qtd_voos'];
			}
			$cod_aeronave_lista = $row['cod_aeronave'];
			if (array_key_exists($cod_aeronave_lista,$vet_pa)) {
				//echo "if. cod_aeronave_lista =".$cod_aeronave_lista."<br>";
				echo "<tr><TD width='300'>Vôos efetuados no ".$row["nome"]."</TD>";
				echo "<TD>".$vet_pa[$cod_aeronave_lista]."</TD></TR>";
			}
			else {
				//echo "cod_aeronave_lista =".$cod_aeronave_lista."<br>";
				echo "<tr><TD width='300'>Vôos efetuados no ".$row["nome"]."</TD>";
				echo "<TD>0</TD></TR>";			
			}
		}				
	?>
</table>
<h4>OUTRAS INFORMAÇÕES</h4>
<table>
  <? 			
  	if ($qtd_voos_ae_desat) {
		echo "<TR><TD width='300'>Quantidade de vôos em aeronaves desativadas&nbsp;</TD>
		<TD>".$qtd_voos_ae_desat."</TD></TR>"; 
	}
  ?>	
  <TR>
    <TD width='300'>Estrelas&nbsp;</TD>
	<? echo "<TD>".$qtd_estrelas."</TD></TR>"; ?>
  <TR>
    <TD width='300'>"Charter Flights"</TD>
    <? echo "<TD>".$qtd_ch."</TD></TR>"; ?>
  <TR>
    <TD width='300'>Vôos Humanitários</TD>
    <? echo"<TD>".$qtd_vh."</TD></TR>"; ?>
  <TR>
    <TD width='300'>Missões Especiais</TD>
	<? echo"<TD>".$qtd_me."</TD></TR>"; ?>
  <TR>
    <TD width='300'>Ordens de Operação</TD>
	<? echo"<TD>".$qtd_op."</TD></TR>"; ?>
</TABLE><br>


<!-- -------------------------------------------------------------------------------------------
	QUALIFICAÇÕES OPERACIONAIS
 ------------------------------------------------------------------------------------------- -->
<h4>Qualificação Operacional</h4>
<TABLE>
  <TR>
	<?
		$sql = "select a.nome, a.nome_guerra, a.imagem_1, pii.data_qo, pii.tipo_qo
				from piloto p, piloto_qo pii, aeronave a
 			 	where pii.data_qo <> '0000-00-00'
				and p.callsign = pii.callsign
				and pii.cod_aeronave = a.cod_aeronave
				and p.callsign = $piloto
				order by pii.data_qo asc";
		$res = mysql_query($sql);		
		while ($row = @mysql_fetch_assoc($res)){	
			if ($row['tipo_qo']=='i'){
				echo "<TR><TD><IMG src=\"". $dir_imagem_aeronaves.$row["imagem_1"]."\" width=\"180\" height=\"71\"></TD><TD>".data_instrutor($row["data_qo"])."<br>INSTRUTOR<BR>".$row["nome"]." - ".$row["nome_guerra"]."</TD></TR>";	
			}
			else {
				echo "<TR><TD><IMG src=\"". $dir_imagem_aeronaves.$row["imagem_1"]."\" width=\"180\" height=\"71\"></TD><TD>".data_instrutor($row["data_qo"])."<br>CMTE. MOR<BR>".$row["nome"]." - ".$row["nome_guerra"]."</TD></TR>";				
			}				
		}
	?>
</TABLE><br>


<!-- -------------------------------------------------------------------------------------------
	CONDECORAÇÕES
 ------------------------------------------------------------------------------------------- -->
<h4>Condecorações</h4>
<TABLE>
	<?
		$sql = "select c.imagem
				from certificado c, piloto_certificado pc, piloto p
				where pc.callsign=p.callsign
				and c.cod_certificado = pc.cod_certificado
				and p.callsign = $piloto";
		$res = mysql_query($sql);
		
		while ($row = mysql_fetch_assoc($res)){
			echo "<TR><TD><IMG src=\"".$dir_imagem_certificados.$row["imagem"]."\" with='100'></TD></TR>";
		}
	?>
</TABLE><br>


<!-- -------------------------------------------------------------------------------------------
		EVENTOS ON LINE
 ------------------------------------------------------------------------------------------- -->
<h4>Eventos Online</h4>
<TABLE>
	<?
		$sql = "select e.imagem
				from evento e, piloto_evento pe, piloto p
				where pe.callsign=p.callsign
				and e.cod_evento = pe.cod_evento
				and p.callsign = $piloto";
		$res = mysql_query($sql);
		
		while ($row = mysql_fetch_assoc($res)){
			echo "<TR><TD><IMG src=\"".$row["imagem"]."\" align=\"center\"></TD></TR>";
		}
	?>
</TABLE>
<script type="text/javascript">
<!--
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
//-->
</script>
