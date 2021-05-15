<?php
	session_start();
	include("../conecta.php");
	include("../funcoes.php");

	if(!isset($_SESSION["callsign"])){
		$opcao_dados="";
	}
	else {
		$callsign = $_SESSION["callsign"];
		$sql = "select * from piloto where callsign=$callsign and status='a'";
		$res = $con->query($sql);
		$row = $res->fetch_assoc();

		$tipo_piloto = $row["tipo_piloto"];
		$nome_guerra = $row["nome_guerra"];
		$ultimo_login = $row["ultimo_login"];
	}
	$pagina='inicio';
	if(isset($_GET["pagina"]))
		$pagina=$_GET["pagina"];
?>
<!DOCTYPE html>

   <head>
      <title>Administra&ccedil;&atilde;o Eccentric Travels</title>
			<link rel="stylesheet" href="adm.css">
			<script charset="utf-8" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   </head>

   <body>
   <div id="tudo">
   <div id="conteudo">
      <table class="bordas">
         <tr>
            <td  style = "width=100px; text-align: center"><img src = "logo.png" /></td>
            <td width="100%">
               <?php
   				if (!isset($callsign)){
					echo "<h3>Login</h3>
					<form action=\"autentica_callsign.php\" method=\"post\" >
						<p>	Callsign: <br /><input name=\"callsign\" type=\"text\" size=\"16\" /><br />
						Senha: <br /><input name=\"senha\" type=\"password\" size=\"16\" /><br /><br />
						<input name=\"a\" type=\"submit\" class=\"login\" value=\"Login\" />
						</p>
					</form>";
				}
				else {
					echo "<h3>Ol&aacute; Cmte. ".utf8_encode($nome_guerra)."</h3>";
					echo "  <p>&Uacute;ltimo Login: ".montadata($ultimo_login)."
					<div align=\"center\"><input name=\"butLogout\" type=\"button\" value=\"Sair\" onclick=\"window.open('index.php?pagina=logout','_self')\"/></div>";
				}
				?>
            </td>
         </tr>
         <?php
         if (isset($tipo_piloto) && $tipo_piloto=='a'){
         	echo "<tr>";
            echo "<td style = \"vertical-align: top\">";
			echo "<h3>Administra&ccedil;&atilde;o</h3>";
			echo "<div>";
			echo "<p><a href=\"index.php?pagina=inicio\">In&iacute;cio</a></p>";
			echo "<p><a href=\"index.php?pagina=adm_aeronaves\">Aeronaves</a></p>";
			echo "<p><a href=\"index.php?pagina=adm_filaespera&opcao=1\">Candidatos</a></p>";
			echo "<p><a href=\"index.php?pagina=editaHome2\">Editar Home</a></p>";
			echo "<p><a href=\"index.php?pagina=estatisticas/adm_estatisticas\">Estat&iacute;sticas</a></p>";
			echo "<p><a href=\"index.php?pagina=adm_icao\">Icaos</a></p>";
			echo "<p><a href=\"index.php?pagina=adm_visitas\">Livro de visitas</a></p>";
			echo "<p><a href=\"index.php?pagina=adm_MEs\">Miss&otilde;es Especiais</a></p>";
			echo "<p><a href=\"index.php?pagina=adm_noticias\">Not&iacute;cias</a></p>";
			echo "<p><a href=\"index.php?pagina=relatorionucleos\">N&uacute;cleos</a></p>";
			echo "<p><a href=\"index.php?pagina=op/ops&opcao=p\">Ordens de Opera&ccedil;&atilde;o</a></p>";
			echo "<p><a href=\"index.php?pagina=listaPais\">Pa&iacute;ses</a></p>";
			echo "<p><a href=\"index.php?pagina=adm_pilotos\">Pilotos</a></p>";
			echo "<p><a href=\"index.php?pagina=relatorios/relatorios\">Relat&oacute;rios</a></p>";
			echo "<p><a href=\"index.php?pagina=adm_REV\">Revoadas</a></p>";
			echo "<p><a href=\"index.php?pagina=adm_rotas\">Rotas</a></p>";
			echo "<p><a href=\"index.php?pagina=adm_MP\">Voos Multiplayer</a></p>";
			echo "</td>";
			echo "<td style = \"vertical-align: top\">";
            include("$pagina.php");
            echo "</td>";
         	echo "</tr>";
         }
      ?>
      </table>
      </div></div>
   </body>
</html>
