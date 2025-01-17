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

/***************** JWT **************/
$secret_Key  	= '$2y$10$b2WWyYaqJDKHLSdw1Jd48.EjDXS6sC9gUXZKidMnlOreFReWl40';
$date   		= new DateTimeImmutable();
$expire_at     	= $date->modify('+3 minutes')->getTimestamp();      
$domainName 	= "acadserv.upaep.mx";
$key		   	= "tech";                                          
$request_data = [
	'iat'  		=> $date->getTimestamp(),        
	'iss'  		=> $domainName,                  
	'nbf'  		=> $date->getTimestamp(),        
	'exp'  		=> $expire_at,                      
	'key' 		=> $key                
];
$auth	=	JWT::encode($request_data,$secret_Key,'HS256');
$url	=	'https://acadserv.upaep.mx/wesley/api/service/tech/';
$post	=	$_GET;
$metodo	=	"GET";
curl($url,$post,$auth,$metodo);
?>
