<?php
  $id = $_GET['num_candidato'];

  $sql = "delete from candidato where num_candidato=$id";
  $res = $con->query($sql);

  echo "<script language=\"JavaScript\">
          window.location=\"index.php?pagina=fila_espera/candidatos\";
        </script> ";
 ?>
