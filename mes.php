<?php
	echo "<h1 class=\"page-header\">Miss&otilde;es especiais</h1>";

	echo "<p align=\"justify\">As Miss&otilde;es Especiais foram institu&iacute;das em 26 de Agosto de 2004 e se constituem de voos para qualquer lugar do Brasil ou do Mundo, onde na vida real esteja acontecendo um fato marcante, como cat&aacute;strofes da natureza (terremotos, vulc&otilde;es, furac&otilde;es, tsunames, etc), guerras ou eventos esportivos. S&atilde;o criadas pelo Presidente, possuem regulamento pr&oacute;prio e os pilotos participam mediante inscri&ccedil;&atilde;o. Um banner alusivo &eacute; concedido aos participantes, assim como as bandeiras dos pa&iacute;ses visitados. Abaixo constam os banners das ME's que j&aacute; ocorreram na \"Eccentric Travels\".</p>";

	echo "<h3>Miss&otilde;es Especiais Conclu&iacute;das</h3>";
	
	$sql = "select * from me where status=0";
	$res = $con->query($sql);
	
	while ($row=$res->fetch_assoc()){
		echo "<p><img src=\"".$dir_imagem_me.$row['imagem']."\" alt=\"".$row['nome']."\"></p>";
	}
?>