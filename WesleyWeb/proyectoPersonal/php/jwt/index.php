<?php
/* JWT */
declare(strict_types=1);
require_once('/var/www/html/wesley/api/libraries/jwt/vendor/autoload.php');
use Firebase\JWT\JWT;
/* Encabezados */
header('Vary: Origin');
header('Access-Control-Allow-Origin: https://acadserv.upaep.mx');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=utf-8');
/* Respuesta **/

if(true){
	if($_POST["jwt"]==true){
		session_start();
		if(!isset($_SESSION["jwt"])){
			$secret_Key  	= '$2y$10$b2WWyYaqJDKHLSdw1Jd48.EjDXS6sC9gUXZKidMnlOreFReWl40';
			$date   		= new DateTimeImmutable();
			$expire_at     	= $date->modify('+3 minutes')->getTimestamp();  
			$domainName 	= "acadserv.upaep.mx";			
			$key		   	= "wesleyProyecto";                                          
			$request_data = [
				'iat'  		=> $date->getTimestamp(),        
				'iss'  		=> $domainName,                  
				'nbf'  		=> $date->getTimestamp(),        
				'exp'  		=> $expire_at,                      
				'key' 		=> $key                
			];
			if($auth=JWT::encode($request_data,$secret_Key,'HS256')){
				$_SESSION["jwt"]=$auth;
				echo '{"status":200,"jwt":"'.$auth.'"}';
			}else{
				echo '{"status":500}';
			}
		}else{
			echo '{"status":200,"jwt":"'.$_SESSION["jwt"].'"}';
		}
	}
}
?>