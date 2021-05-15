<script type="text/javascript">
  var _url = 'relatorios/json.php?filtro=1'
  $(document).ready(function(){
    $(document).on('change','#opcaorel',function(){
      var valor = $('#opcaorel').val();
      _url = 'relatorios/json.php?filtro='+valor;
      console.log(_url);
      carrega();
    });
  });

  //1,2,3,4,5 'Aguardando','Aprovado','Reprovado','Cancelado','Pendente'

  $(document).ready(function(){
    carrega();
  });

  function carrega(){
    var relatorio_data ='';
    $('#tab_relatorios').empty();
    $.ajax({
      type:'post',
      dataType: 'json',
      url: _url,
      success: function(relatorio_data){
        $('#tab_relatorios').append("<thead><tr><th>N&uacute;cleo</th><th>Callsign</th><th>N&uacute;mero</th><th>Data Envio</th><th>Nome</th><th>Status</th><th>A&ccedil;&otilde;es</th></tr></thead>");
        $.each(relatorio_data,function(i,item){
          $('#tab_relatorios').append(
            '<tr>'+
            '<td>'+item.nucleo+'</td>'+
            '<td>'+item.callsign+'</td>'+
            '<td>'+item.numero+'</td>'+
            '<td>'+item.data_envio+'</td>'+
            '<td>'+item.nome_guerra+'</td>'+
            '<td>'+item.status+'</td>'+
            '<td><a href="index.php?pagina=relatorios/visualiza_relatorio&numero='+item.numero+'">Detalhes</a>'+
            '</tr>'
          );
        });
      }
    });
  }

</script>
<?php
  $filtro = empty($_GET['filtro'])?'Todos':$_GET['filtro'];

  echo"
    <p>Filtro por Status:
      <select name='opcaorel' id='opcaorel'>";
  echo "<option value='1'";if($filtro=='Aguardando') echo "selected"; echo">Aguardando</option>";
  echo "<option value='2'";if($filtro=='Aprovado') echo "selected"; echo">Aprovado (Esta opção é demorada)</option>";
  echo "<option value='3'";if($filtro=='Reprovado') echo "selected"; echo">Reprovado</option>";
  echo "<option value='4'";if($filtro=='Cancelado') echo "selected"; echo">Cancelado</option>";
  echo "<option value='5'";if($filtro=='Pendente') echo "selected"; echo">Pendente</option>";
  echo "</select>";
?>
</p>
<br>
<table id="tab_relatorios"></table>
