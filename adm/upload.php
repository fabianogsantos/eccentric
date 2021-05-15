<?php
include("../conecta.php");

$legenda = empty($_POST["legenda"])?'':$_POST["legenda"];
if ($_FILES["fileToUpload"]["size"]==0){
  $imagem = '';
}
else {
  $imagem = 1;
}

if (!empty($legenda)&&empty($imagem)){
  $agora = date('Y-m-d');
  $sql = "update homepage set data = '$agora',legenda ='$legenda' where id=1";
  $res = $con->query($sql);
  ?>
  <script>
      alert("Somente a legenda foi atualizada. A imagem permanece pois não foi enviada.");
      window.location="index.php?pagina=editaHome2";
  </script>
  <?php
}
else {
  $target_dir = "upload/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
      $legenda = $_POST['legenda'];
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          $uploadOk = 1;
      } else {
          echo "O arquivo não é uma imagem.";
          $uploadOk = 0;
      }
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
      echo "O tamanho do arquivo é maior que 500000.";
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      echo "Somente JPG, JPEG, PNG & GIF são permitidos.";
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Upload NÃO foi feito.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          $agora = date('Y-m-d');
          $sql = "update homepage set imagem = '$target_file',data = '$agora',legenda ='$legenda' where id=1";
          $res = $con->query($sql);

          if(!$res ){
              ?>
              <script>
                  alert("O upload NÃO foi feito!");
                  window.location="index.php?pagina=editaHome2";
              </script>
              <?php
          }
          else {
          ?>
          <script>
              alert("O upload foi feito corretamente");
              window.location="index.php?pagina=editaHome2";
          </script>
          <?php
          }
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }
}
?>
