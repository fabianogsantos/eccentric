<?php
	if(!isset($_SESSION["callsign"])){
		echo "<h3>Sobre o nosso fórum</h3><br /><p align='justify'>O Diário de Bordo é o Fórum personalizado da Eccentric Travels, criado em 10 de novembro de 2004, de uso restrito aos pilotos após estarem logados. Os assuntos a serem postados no Fórum devem ser de interesse coletivo, preferencialmente relacionados à aviação virtual.</p>";
	}
	else {
		echo "<h2>Sobre o fórum</h2>
		<p>O <strong>novo</strong> fórum ficou ativo por muito tempo, porém praticamente não teve participação dos pilotos. Vou voltar ao formato do site antigo para ver se a participação é maior. Aguarde até lá. Obrigado, cmte. Fabiano</p>";
	}//fim do else
?>
