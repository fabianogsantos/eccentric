function LinkFormatter(value, row, index) {
  return "<a href='index.php?pagina=icaos/icao&icao="+row.icao+"'>"+value+"</a>";
}

function LinkFormatterPais(value, row, index) {
  return "<a href='index.php?pagina=paises/pais&cod_pais="+row.cod_pais+"'>"+value+"</a>";
}
function LinkFormatterImgPais(value, row, index) {
  return "<img src='../"+row.imagem+"' alt='"+row.nome+"'>";
}

function LinkFormatterVoo(value, row, index) {
  return "<a href='index.php?pagina=voos/voo&num="+row.num+"'>"+value+"</a>";
}

function LinkFormatterRev(value, row, index) {
  return "<a href='index.php?pagina=revoadas/revoada&cod="+row.cod+"'>"+value+"</a>";
}
function LinkFormatterImgRev(value, row, index) {
  return "<img src='../imagens/rev/"+row.imagem+"' alt='"+row.nome+"'>";
}

function LinkFormatterMP(value, row, index) {
  return "<a href='index.php?pagina=mp/mp&cod="+row.cod+"'>"+value+"</a>";
}

function LinkFormatterImgMP(value, row, index) {
  return "<img src='../imagens/mp/"+row.imagem+"' alt='"+row.nome+"'>";
}

function LinkFormatterME(value, row, index) {
  return "<b><a href='index.php?pagina=me/me&cod="+row.cod+"'>"+value+"</a></b>";
}

function LinkFormatterImgME(value, row, index) {
  return "<img src='../imagens/me/"+row.imagem+"' alt='"+row.nome+"'>";
}

function LinkFormatterIdNoticia(value, row, index) {
  return "<b><a href='index.php?pagina=noticias/noticia&id="+row.id+"'>"+value+"</a></b>";
}

function formataDataNoticia(value, row, index) {
  return row.texto;
}

function substrTexto(value, row, index) {
  return row.texto.substring(0,130);
}

function LinkFormatterCandidato(value, row, index) {
  return "<b><a href='index.php?pagina=fila_espera/candidato&num_candidato="+row.num_candidato+"'>"+value+"</a></b>";
}

function LinkFormatterNroRelatorio(value, row, index) {
  return "<b><a href='index.php?pagina=relatorios/relatorio&numero="+row.numero+"'>"+value+"</a></b>";
}

function LinkFormatterPiloto(value, row, index) {
  return "<b><a href='index.php?pagina=pilotos/piloto&callsign="+row.callsign+"'>"+value+"</a></b>";
}

function linkAltDossie(value, row, index) {
  return "<a href='index.php?pagina=pilotos/dossie_piloto&callsign="+row.callsign+"'>Alterar</a> / <a href='../index.php?pagina=dossie&piloto_callsign="+row.callsign+"'>Ver Dossiê</a>";
}

function LinkFormatterOP(value, row, index) {
  return "<b><a href='index.php?pagina=op/op&id="+row.id+"'>"+value+"</a></b>";
}

function LinkFormatterCodAeronave(value, row, index) {
  return "<b><a href='index.php?pagina=aeronaves/aeronave&cod_aeronave="+row.cod_aeronave+"'>"+value+"</a></b>    ";
}

$('#filtro_filaespera').change(function(){
  var valor = $('#filtro_filaespera').val();
  $(location).attr('href','index.php?pagina=fila_espera/candidatos&filtro='+valor);
});

$('#filtro_relatorios').change(function(){
  var valor = $('#filtro_relatorios').val();
  $(location).attr('href','index.php?pagina=relatorios/relatorios&filtro='+valor);
});

$('#filtro_ops').change(function(){
  var valor = $('#filtro_ops').val();
  $(location).attr('href','index.php?pagina=op/ops&filtro='+valor);
});

$('#filtro_pilotos').change(function(){
  var valor = $('#filtro_pilotos').val();
  $(location).attr('href','index.php?pagina=pilotos/pilotos&filtro='+valor);
  //filterData(valor);
});