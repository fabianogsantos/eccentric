<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php?pagina=inicio">
          <img src="<?=$dir_imagem."/diversos/seagull_logo.png";?>"/>
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Base
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="index.php?pagina=estatisticas">Estat&iacute;sticas</a></li>
                <li><a href="index.php?pagina=eventosonline">Eventos online</a></li>
                <li><a href="index.php?pagina=mes">Miss&otilde;es especiais</a></li>
                <li><a href="index.php?pagina=pagina&pid=19">Voos fretados e humanit&aacute;rios</a></li>
                <li><a href="index.php?pagina=pagina&pid=14">Hist&oacute;rico</a></li>
                <li><a href="index.php?pagina=diretoria">Sala da Diretoria</a></li>
                <li class="divider"></li>
                <li><a href="index.php?pagina=sobre">Sobre o site</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Rotas
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="index.php?pagina=pagina&pid=18">Cat&aacute;logo de rotas</a></li>
               <li><a href="index.php?pagina=pagina&pid=16">Ordens de Opera&ccedil;&atilde;o</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Downloads
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="index.php?pagina=down_aeronaves">Aeronaves</a></li>
                <li><a href="index.php?pagina=arquivos/frame">Outros arquivos</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Pilotos
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="index.php?pagina=efetivo">Lista de pilotos</a></li>
                <li><a href="index.php?pagina=dossies_pilotos">Dossi&ecirc;s dos pilotos</a></li>
                <li class="divider"></li>
                <li><a href="index.php?pagina=formInscricao">Inscreva-se</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Fórum
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="index.php?pagina=forum" target="_blank">Entrar</a></li>
            </ul>
            <li><a href="index.php?pagina=contato">Contato</a></li>
        </li>
        <?php
            if (isset($_SESSION['callsign'])){?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Minha Eccentric<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?pagina=alterar_dados">Meus dados</a></li>
                        <li><a href="index.php?pagina=dossie&piloto_callsign=<?=$callsign?>">Meu Dossi&ecirc;</a></li>
                        <li><a href="index.php?pagina=nucleo&nucleo=<?=$nucleo?>">Meu N&uacute;cleo</a></li>
                        <li><a href="index.php?pagina=op/minhas_ops">Minhas OPs</a></li>
                        <li><a href="index.php?pagina=relatorios/relatorios&piloto=<?=$callsign?>">Meus Relat&oacute;rios</a></li>
                    </ul>
                
            <?php 
                if ($_SESSION['tipo_piloto']=='a'){
                    echo "<li><a href=\"/adm2\"><strong>IR PARA ADMIN</strong></a></li>";
                }
                echo "</li>";
            }
            ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <?php if (!isset($_SESSION['callsign'])){
        ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Entrar <span class="caret"></span></a>
          <ul id="login-dp" class="dropdown-menu">
    				<li>
    					 <div class="row">
    							<div class="col-md-12">
    								 <form class="form" role="form" method="post" action="autentica_callsign.php" accept-charset="UTF-8" id="login-nav">
    										<div class="form-group">
    											 <label class="sr-only" for="usuario">Usuário</label>
    											 <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário" required>
    										</div>
    										<div class="form-group">
    											 <label class="sr-only" for="senha">Senha</label>
    											 <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
                           <div class="help-block text-right"><a href="">Esqueci a senha</a></div>
    										</div>
    										<div class="form-group">
    											 <button type="submit" class="btn btn-primary btn-block">Entrar</button>
    										</div>
    								 </form>
    							</div>
    					 </div>
    				</li>
          </ul>
        </li>
        <?php }
        else {?>
            <li class="dropdow">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Olá Cmte. <?php echo getNomeGuerra($_SESSION['callsign'],$con);?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href='index.php?pagina=logout'>Desconectar</a></li>
                </ul>
            </li>
        <?php
        }

        ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
