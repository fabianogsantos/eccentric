<?php
session_start();
  	include("../configura.php");
	include("../conecta.php");
  	include("../funcoes.php");

	if(!isset($_SESSION["callsign"])){
		$opcao_dados="";
		GoToNow('http://www.eccentrictravels.org');
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
	
	include('header.php'); 
?>
</head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php?pagina=inicio"><strong>Eccentric ADM</strong></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
						<li><a href="../index.php">Ir para o site</a></li>
						<li><a href="logout.php">Sair da Adm</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
						<?php include 'nav.php'; ?>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<?php include("$pagina.php"); ?>
        </div>
      </div>
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>
