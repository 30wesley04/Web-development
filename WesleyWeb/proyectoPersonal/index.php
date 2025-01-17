<?php

  require '../api/helper/db.php';
  require 'includes/templates/functions.php';
  $auth=estaAutenticado();
  if(!$auth){
      header('Location: login.html');
  }
  $usuario = $_SESSION['usuario'];

  $query="SELECT * FROM usuarios WHERE usuario='{$usuario}';";
  $resultado = $mysqli->query($query);
  $usuario = mysqli_fetch_assoc($resultado);
  $nombre=$usuario['nombre'];
  $correo=$usuario['usuario'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <title>Admin</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link
          href="https://fonts.googleapis.com/css2?family=Mulish&display=swap"
          rel="stylesheet"
      >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/normalize.css">
      <link rel="stylesheet" href="css/styles.css">
      <script defer src="js/sidebar.js"></script>
      <script defer src="js/functions3.js"></script>
      <script defer src="https://kit.fontawesome.com/6911c1abd9.js" crossorigin="anonymous"></script>
    </head>
    <body class="bodyAdmin">
        <?php
          include 'includes/templates/sidebar.php';
        ?>
        <main class="contenedor grid__personas">

            
         
          
        </main>
    </body>
</html>