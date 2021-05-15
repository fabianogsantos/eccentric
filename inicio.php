<?php
    include 'conecta.php';

    $sql = "select imagem,legenda from homepage ORDER BY ID DESC LIMIT 1";
    $res = $con->query($sql) or die("Error description: " . mysqli_error($con));
    $row = $res->fetch_assoc();
 ?>

<div class="row">
    <div class="col-md-12">
      <div class="page-header">
        <h1>Bem-vindo(a) &agrave; Eccentric Travels!</h1>
        <small>Uma das mais antigas companhias a&eacute;reas virtuais do pa&iacute;s.</small>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <img class="img-responsive img-rounded" src="<?php echo $dir_imagem_home.$row['imagem'];?>" alt="Eccentric Travels">
    </div>
    <div class="col-md-4">
      <em><?php echo $row['legenda'];?></em>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="well well-sm text-center">
            <?php montaCabecalho($con);?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <h2>Vantagens da Cia</h2>
        <p>Companheirismo, elevado nível de feedback, rotas, aeronaves, dossiês, incentivos, qualificação, carreira, entre outras.Veja o que a ETR tem para você.</p>
        <a class="btn btn-primary" href="index.php?pagina=pagina&pid=7">Saber mais</a>
        <a class="btn btn-success" href="http://www.eccentrictravels.org/index.php?pagina=formInscricao">Inscreva-se</a>
    </div>

    <!-- /.col-md-4 -->
    <div class="col-md-3">
        <h2>Regulamento</h2>
        <p>Invista uns minutos do seu tempo lendo o Regulamento Geral. É de fácil leitura, com índice de acesso rápido, separado por tópicos, e artigos curtos.</p>
        <a class="btn btn-success" target="_blank" href="Regulamento.htm">Ler o regulamento</a>
    </div>

    <!-- /.col-md-4 -->
    <div class="col-md-3">
        <h2>Aeronaves</h2>
        <p>São 34 aeronaves ao todo as quais são liberadas de acordo com a sua carreira na ETR. Compatíveis com o FS9 e FSX!</p>
        <a class="btn btn-warning" href="index.php?pagina=hangar">Ver o Hangar</a>
    </div>

    <div class="col-md-3">
    	<h2>Aniversariantes</h2>
    	<p>Parabéns aos aniversariantes do mês</br>
    	<?php
	    	$sql = "select extract(day from data_nasc) as dia, nome_guerra
	    	        from piloto
	    	        where extract(month from data_nasc)=extract(month from  now())
	    	        and status='a'";
	    	$res = $con->query($sql);
	    	$num = $res->num_rows;

	    	while ($row=$res->fetch_assoc()){
            	echo "Dia ".$row["dia"].": Cmte. ".$row["nome_guerra"]."<br>";
			}
    	?>
        </p>
    </div>
    <!-- /.col-md-4 -->
</div> <!-- /.row -->
<hr>
<div class="row">
    <div class="col-lg-12">
        <?php include("noticias.php"); ?>
    </div>
</div>