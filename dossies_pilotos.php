<h3 class="page-header">Dossi&ecirc;s dos Pilotos</h3>
<div class="row">
	<div class="col-md-8">
		<?php
		echo "<TABLE class='table table-condensed table-hover'>";
		for ($cod_posto = 8; $cod_posto >= 1; $cod_posto--) {
			$sql_posto = "select * from posto where cod_posto = $cod_posto";
			$res_posto = $con->query($sql_posto);
			$row_posto = $res_posto->fetch_assoc();

			$sql = "select * from piloto where cod_posto=$cod_posto and status = 'a' order by callsign";
			$res = $con->query($sql);
			while ($row = $res->fetch_assoc()) {
				$piloto_callsign = $row["callsign"];

				if ($cod_posto == 8) {
					//verifica quantas aeronaves o cara é instrutor
					$sql_num_ae = "select count(callsign) as qtd from piloto_qo where callsign = $piloto_callsign and data_qo <> '0000-00-00' and tipo_qo='i'";
					$res_num_ae = $con->query($sql_num_ae);
					$num_ae = $res_num_ae->fetch_assoc();
					$num_ae = $num_ae['qtd'];
					$num_ae = " - Q" . $num_ae;

					//verifica quantas aeronaves o cara é comandante-mor
					$sql_num_ae = "select count(callsign) as qtd from piloto_qo where callsign = $piloto_callsign and data_qo <> '0000-00-00' and tipo_qo='c'";
					$res_num_ae = $con->query($sql_num_ae);
					$num_ae_c = $res_num_ae->fetch_assoc();
					$num_ae_c = $num_ae_c['qtd'];
					$num_ae = $num_ae . "/" . $num_ae_c;
				} else {
					$num_ae = "";
				}

				//monta vetor contendo os certificados que o cara possui
				$sql_pi_certif = "select c.imagem,c.des_certificado
							  from piloto_certificado pc, piloto p, certificado c
                              where p.callsign = pc.callsign
	                          and c.cod_certificado = pc.cod_certificado
                              and p.callsign=$piloto_callsign";
				$res_pi_certif = $con->query($sql_pi_certif);

				$certificados = "";
				if ($res_pi_certif->num_rows > 0) {
					while ($row_pi_cert = $res_pi_certif->fetch_assoc()) {
						$certificados = $certificados . "<img src=\"" . $dir_imagem_certificados . $row_pi_cert["imagem"] . "\" alt=\"" . utf8_encode($row_pi_cert["des_certificado"]) . "\">";
					}
				}

				//monta vetor contendo os cargos que o cara possui
				$sql_pi_cargo = "select c.des_cargo,c.imagem 
							  from piloto_cargo pc, piloto p, cargo c
                              where p.callsign = pc.callsign
	                          and c.cod_cargo = pc.cod_cargo
    	                      and p.callsign=$piloto_callsign";
				$res_pi_cargo = $con->query($sql_pi_cargo);
				$num_linhas = $res_pi_cargo->num_rows;
				if ($num_linhas > 0) {
					while ($row_pi_cargo = $res_pi_cargo->fetch_assoc()) {
						$certificados = $certificados . "<img src=\"" . $dir_imagem_certificados . $row_pi_cargo["imagem"] . "\" alt=\"" . utf8_encode($row_pi_cargo["des_cargo"]) . "\">";
					}
				}

				//monta a saída para a tela
				echo "<TR><TD><A HREF=\"index.php?pagina=dossie&piloto_callsign=" . $piloto_callsign . "\">" . utf8_encode(strtoupper($row["nome_guerra"])) . " - ETR" . completazeros($piloto_callsign) . $num_ae . "</a></td><td>";
				echo "<IMG src=\"" . $dir_imagem_posto . $row_posto["imagem"] . "\">";

				//monta os extras (cargo e certificados) de cada piloto
				if (!empty($certificados))
					echo $certificados . "</TD></TR>";
				else
					echo "</TD></TR>";
				$certificados = "";
				$cor = 1;
			}
		} //fim for
		echo "</TABLE>";
		?>
		<p><strong>Legenda</strong></p>
		<img src="<?= $dir_imagem_posto ?>posto8.png" alt="Sky Master">&nbsp;Sky Master<br>
		<img src="<?= $dir_imagem_posto ?>posto7.png" alt="Cmte Transcontinental">&nbsp;Cmte Transcontinental<br>
		<img src="<?= $dir_imagem_posto ?>posto6.png" alt="Cmte Internacional">&nbsp;Cmte Internacional<br>
		<img src="<?= $dir_imagem_posto ?>posto5.png" alt="Co-Pioto Internacional">&nbsp;Co-Pioto Internacional<br>
		<img src="<?= $dir_imagem_posto ?>posto4.png" alt="Primeiro Oficial Internacional">&nbsp;Primeiro Oficial Internacional<br>
		<img src="<?= $dir_imagem_posto ?>posto3.png" alt="Cmte Regional">&nbsp;Cmte Regional<br>
		<img src="<?= $dir_imagem_posto ?>posto2.png" alt="Co-Piloto regional">&nbsp;Co-Piloto Regional<br>
		<img src="<?= $dir_imagem_posto ?>posto1.png" alt="Primeiro Oficial Regional">&nbsp;Primeiro Oficial Regional<br>
		<img src="<?= $dir_imagem_certificados ?>fiel.png" alt="Piloto Fiel">&nbsp;Piloto Fiel<br>
		<img src="<?= $dir_imagem_certificados ?>veterano.png" alt="Veterano">&nbsp;Veterano<br>
		<img src="<?= $dir_imagem_certificados ?>mildecolagens.png" alt="Mil decolagens">&nbsp;Mil decolagens<br>
		<img src="<?= $dir_imagem_certificados ?>cargo.png" alt="Certified Cargo Pilot">&nbsp;Certified Cargo Pilot<br>
		<img src="<?= $dir_imagem_certificados ?>private.png" alt="Certified Private Pilot">&nbsp;Certified Private Pilot<br>
		<img src="<?= $dir_imagem_certificados ?>voofh.png" alt="Piloto de Voos Fretados e Humanitários">&nbsp;Piloto de Voos Fretados e Humanitários<br>
		<img src="<?= $dir_imagem_certificados ?>passenger.png" alt="Certified Passenger Pilot">&nbsp;Certified Passenger Pilot<br>
		<img src="<?= $dir_imagem_certificados ?>presidente.png" alt="Presidente">&nbsp;Presidente<br>
		<img src="<?= $dir_imagem_certificados ?>diretor.png" alt="Diretor">&nbsp;Diretor<br>
	</div>
</div>