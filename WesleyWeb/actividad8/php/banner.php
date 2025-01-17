<?php
/********** Mostrar errores ***********/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

if(!isset($_GET)){
	echo '{"status":500,"description":"Error de paramteros"}';
	exit();
}

/********** Archivo de conexión *******/
include 'conexion.php';
$mysqli=conexion();

/********** Respuesta *****************/
$sql 	= "SELECT * FROM 
						banner
							WHERE 
								estatus=1";
$result = $mysqli -> query($sql);
if($result->num_rows>0){
	$row 			= $result -> fetch_all(MYSQLI_ASSOC);
	$a=0;
	$json["html"]='';
	foreach($row as $key => $value) {
		if($a==0){
			$json["html"].='<div class="carousel-item active">';
		}else{
			$json["html"].='<div class="carousel-item">';
		}
		$json["html"].='<img src="'.$value['url'].'" class="d-block w-100" alt="'.$value['title'].'">';
		$json["html"].='</div>';
		$a++;
	}	 
	$json["status"]	= 200; 
	echo json_encode($json);
}else{
	echo '{"status":500}';
}
	
/********** Liberar conexión **********/
$result -> free_result();
$mysqli -> close();
?>
