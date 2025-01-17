<?php

/********** Mostrar errores ************/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/********** Librerías *****************/
require_once('/var/www/html/wesley/api/libraries/jwt/vendor/autoload.php');
require_once('/var/www/html/wesley/api/libraries/removebg/vendor/autoload.php');
use Firebase\JWT\JWT;
use Mtownsend\RemoveBg\RemoveBg;
include 'functions.php';

/********** Configuración *************/
session_start();
header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD']==='POST'){

/********** Validación de datos *******/

if (
    !isset($_POST['frase']) ||
    !isset($_POST['nombre']) ||
    !isset($_POST['edad']) ||
    !isset($_POST['ciudad']) ||
    !isset($_POST['pais']) ||
    !isset($_POST['profesion']) ||
    !isset($_POST['estado_civil']) ||
    !isset($_POST['biografia']) ||
    !isset($_FILES['imagen'])
) {
    echo '{"status":500,"description":"Error de parametros"}';
    exit();
}

if (empty($_FILES['imagen']['tmp_name'])) {
    echo '{"status":400,"description":"La foto del CV es obligatoria"}';
    exit();
    
}

if(empty($_POST['frase'])){
    echo '{"status":400,"description":"La frase es obligatoria"}';
    exit();
}

if(empty($_POST['nombre'])){
    echo '{"status":400,"description":"Debe ingresar un nombre"}';
    exit();
}

if(empty($_POST['edad'])){
    echo '{"status":400,"description":"Debe ingresar una edad"}';
    exit();
}
if(empty($_POST['ciudad'])){
    echo '{"status":400,"description":"Debe ingresar una ciudad"}';
    exit();
}
if(empty($_POST['pais'])){
    echo '{"status":400,"description":"Debe ingresar un pais"}';
    exit();
}
if(empty($_POST['profesion'])){
    echo '{"status":400,"description":"Debe ingresar una profesion"}';
    exit();
}
if(empty($_POST['estado_civil'])){
    echo '{"status":400,"description":"Debe ingresar un estado civil"}';
    exit();
}

if(empty($_POST['tecnologias_id'])){
    echo '{"status":400,"description":"Debe selccionar al menos una tecnologia"}';
    exit();
}
if(empty($_POST['calificacion'])){
    echo '{"status":400,"description":"Debe calificar al menos una tecnologia"}';
    exit();
}
if(empty($_POST['biografia'])){
    echo '{"status":400,"description":"Debe ingresar una biografia"}';
    exit();
}
if(empty($_POST['favoriteBrands'])){
    echo '{"status":400,"description":"Debe selccionar al menos una marca favorita"}';
    exit();
}
if (empty($_POST['needs']) || count(array_filter($_POST['needs'])) === 0) {
    echo '{"status":400,"description":"Debe ingresar al menos una necesidad"}';
    exit();
}
if (empty($_POST['frustrations']) || count(array_filter($_POST['frustrations'])) === 0) {
    echo '{"status":400,"description":"Debe ingresar al menos una frustracion"}';
    exit();
}

$imagen = $_FILES['imagen'];
$carpetaImagenes = '../fotosUser/';
if (!is_dir($carpetaImagenes)) {
    mkdir($carpetaImagenes); // Si no existe la carpeta imágenes, la creamos
}
// Asignar nombre único a la imagen
$nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

// Subir la imagen
move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

// Utilizar remove-bg para quitar el fondo
$apiKey = 'B4iHjFPjo37qZygg5gejX664'; 
$removebg = new RemoveBg($apiKey);

$pathToImage = $carpetaImagenes . $nombreImagen;

try {
    // Guardar la imagen con fondo removido
    $result = $removebg->file($pathToImage)->save($carpetaImagenes . 'sin_fondo_' . $nombreImagen);

    if ($result) {
        unlink($carpetaImagenes . $nombreImagen);
    } 
} catch (Exception $e) {
    unlink($carpetaImagenes . $nombreImagen);
    echo '{"status":500,"description":"No se pudo quitar el fondo de la imagen, el archivo no es valido"}';
    exit();
}

$_POST['foto']=$nombreImagen;


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
$metodo = "POST";



// Realiza la solicitud CURL
curl($url, $post, $auth, $metodo);
}

if($_SERVER['REQUEST_METHOD']==='GET'){

/***************** JWT **************/
$secret_Key     = '$2y$10$b2WWyYaqJDKHLSdw1Jd48.EjDXS6sC9gUXZKidMnlOreFReWl40';
$date           = new DateTimeImmutable();
$expire_at      = $date->modify('+3 minutes')->getTimestamp();      
$domainName     = "acadserv.upaep.mx";
$key            = "cv";                                          
$request_data = [
    'iat'       => $date->getTimestamp(),        
    'iss'       => $domainName,                  
    'nbf'       => $date->getTimestamp(),        
    'exp'       => $expire_at,                      
    'key'       => $key                
];
$auth   =   JWT::encode($request_data,$secret_Key,'HS256');
$url    =   'https://acadserv.upaep.mx/wesley/api/service/cv/';
$post   =   $_GET;
$metodo =   "GET";
curl($url,$post,$auth,$metodo);


    
}


