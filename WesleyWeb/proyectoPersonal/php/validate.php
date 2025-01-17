<?php
/* JWT */
require_once('/var/www/html/german/api/libraries/jwt/vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
/* Encabezados */
header('Vary: Origin');
header('Access-Control-Allow-Origin: https://acadserv.upaep.mx');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=utf-8');
/* Respuesta **/
if($_SERVER["HTTP_SEC_FETCH_SITE"]=="same-origin"){
    session_start();
    if(!isset($_SESSION["jwt"])){
        echo '{"status":500,"error":"Error sesión"}'; 
        die();
    }else{
        $secret_Key  	= '$2y$10$b2WWyYaqJDKHLSdw1Jd48.EjDXS6sC9gUXZKidMnlOreFReWl40';
        try{
            $decoded 	= 	JWT::decode($_SESSION["jwt"], new Key($secret_Key, 'HS256'));	
        }catch (Exception $e){
			$secret_Key  	= '$2y$10$b2WWyYaqJDKHLSdw1Jd48.EjDXS6sC9gUXZKidMnlOreFReWl40';
			$date   		= new DateTimeImmutable();
			$expire_at     	= $date->modify('+3 minutes')->getTimestamp();  
			$domainName 	= "acadserv.upaep.mx";			
			$key		   	= "wesley";                                          
			$request_data = [
				'iat'  		=> $date->getTimestamp(),        
				'iss'  		=> $domainName,                  
				'nbf'  		=> $date->getTimestamp(),        
				'exp'  		=> $expire_at,                      
				'key' 		=> $key                
			];
			if($auth=JWT::encode($request_data,$secret_Key,'HS256')){
				$_SESSION["jwt"]=$auth;
				
			}	
        } 
        if(!isset($_SESSION["login"]) || !isset($_SESSION["usuario"])){
            echo '{"status":500,"description":"Error sesión"}'; 
        }else{
			// Include the session variables in the response
            $response = [
                "status" => 200,
                "description" => "Sesión iniciada",
                "id" => $_SESSION['id'], 
				"usuario"=>$_SESSION['usuario']
            ];
            echo json_encode($response);
		}         
    }
}
?>