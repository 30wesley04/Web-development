<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

if(!isset($_POST)){
	echo '{"status":500,"description":"Error de paramteros"}';
	exit();
}

include 'conexion.php';
$mysqli = conexion();

$response = array(); // Crear un array para la respuesta

$query = "SELECT * FROM banner WHERE estatus=1";
$resultado = $mysqli->query($query);

if ($resultado->num_rows > 0) {
    $rows = $resultado->fetch_all(MYSQLI_ASSOC);
    $response = array(
        "status" => 200,
        "data" => $rows
    );
    echo json_encode($response);
} else {
    echo '{"status":500}';
}



 

?>