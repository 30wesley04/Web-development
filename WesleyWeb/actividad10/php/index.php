<?php
/********** Mostrar errores ***********/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

if (!isset($_POST['usuario']) || !isset($_POST['password'])) {
    echo '{"status": 500, "description": "Error de parametros"}';
    exit();
}

/********** Archivo de conexión *******/
include 'conexion.php';
$mysqli = conexion();

/********** Validación de correo electrónico **********/
$usuario = $_POST['usuario'];
if (!filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
    echo '{"status": 400, "description": "El campo usuario no es un correo electrónico válido"}';
    exit();
}

/********** Respuesta *****************/
$sql = "SELECT * FROM usuarios WHERE usuario = '" . $usuario . "' AND password = '" . $_POST["password"] . "'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $row["status"] = 200;
    echo json_encode($row);
} else {
    echo '{"status": 500, "description": "Error de consulta"}';
}

/********** Liberar conexión **********/
$result->free_result();
$mysqli->close();
?>
