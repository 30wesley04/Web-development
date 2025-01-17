<?php
/********** Mostrar errores ***********/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

if(!isset($_POST['usuario']) or !isset($_POST['password'])){
	echo '{"status":500}';
	exit();
}

/********** Archivo de conexión *******/
include 'conex.php';
$mysqli=conexion();

/********** Respuesta *****************/
$sql 	= "SELECT * FROM 
						usuarios 
					WHERE 
						usuario	='".$_POST["usuario"] ."' 
					AND 
						password='".$_POST["password"]."'";
$result = $mysqli -> query($sql);
if($result->num_rows>0){
	$row 			= $result -> fetch_array(MYSQLI_ASSOC);
	$row["status"]	= 200; 
	echo json_encode($row);
}else{
	echo '{"status":500}';
}
	
/********** Liberar conexión **********/
$result -> free_result();
$mysqli -> close();
?>
