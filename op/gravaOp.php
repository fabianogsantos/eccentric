<?php
    $icaos = $_SESSION['icaos'];
    $hoje = br2ansi(Date("d/m/y"));
    $callsign = $_SESSION['callsign'];
    $data_pedido = $hoje;
    $cod_aeronave = $_SESSION['aeronave'];
    $motivo = 'x';
    $status = 'p'; 
    $numicaos = count($_SESSION['icaos']);
    $nropernas = $numicaos-1;
    $qtd = 0; 
    $escalas = strtoupper(implode('-',$icaos));
   
    $sql = "select * from aeronave where cod_aeronave = $cod_aeronave";
    $res = $con->query($sql);
    $aeronave = $res->fetch_assoc();
    $aeronave =$aeronave['nome'];

    $sql = "insert into op (callsign,escalas,cod_aeronave,status,motivo,data_pedido,nropernas) 
            values
            ($callsign, '$escalas', $cod_aeronave,'$status','$motivo','$data_pedido',$nropernas)";
    
    if ($con->query($sql) === TRUE) {
        echo "<h3 class=\"page-header\">Solicitação de OP realizada</h3>";
        echo "<p><strong>Aguarde a resposta da Diretoria para iniciá-la.</strong></p>";
        echo "<p>Guarde estes dados para seu controle:</p>";
        echo "<p><strong>Aeronave</strong>: ".$aeronave."</p>";
        echo "<p><strong>Escalas:</strong> ".$escalas."</p>";
    }
