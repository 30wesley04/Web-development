<?php

/********** Mostrar errores ************/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/********** Librerías *****************/
require_once('/var/www/html/wesley/api/libraries/jwt/vendor/autoload.php');
use Firebase\JWT\JWT;
include 'functions.php';

/********** Configuración *************/
session_start();
header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD']==='POST'){

   

/********** Validación de datos *******/

if (!isset($_POST['id']) || !isset($_POST['imagen'])) {
    echo '{"status":500,"description":"Error de parametros"}';
    exit();
}else{
    $imagen=$_POST['imagen'];
    $carpetaImagenes='../fotosUser/sin_fondo_';
    unlink($carpetaImagenes.$imagen);
}




/***************** JWT **************/
$secret_Key = '$2y$10$b2WWyYaqJDKHLSdw1Jd48.EjDXS6sC9gUXZKidMnlOreFReWl40';
$date = new DateTimeImmutable();
$expire_at = $date->modify('+3 minutes')->getTimestamp();
$domainName = "acadserv.upaep.mx";
$key = "cv";
$request_data = [
    'iat' => $date->getTimestamp(),
    'iss' => $domainName,
    'nbf' => $date->getTimestamp(),
    'exp' => $expire_at,
    'key' => $key
];
$auth = JWT::encode($request_data, $secret_Key, 'HS256');
$url = 'https://acadserv.upaep.mx/wesley/api/service/cv/';
$post = $_POST;
$metodo = "DELETE";



// Realiza la solicitud CURL
curl($url, $post, $auth, $metodo);


    
}
