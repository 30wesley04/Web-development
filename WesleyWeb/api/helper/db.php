<?php
@$mysqli = new mysqli("localhost","user7","user7","user7");

if ($mysqli -> connect_errno) {
	echo '{"status":500,"error":"Failed to connect to MySQL: '. $mysqli -> connect_error.'"}';
	exit();
}

// function conectarDB():mysqli{
//     $db=mysqli_connect('localhost','user7','user7','user7');

//     if(!$db){
//         echo "No se pudo conectar";
//         exit;
//     }

//     return $db;
//   }