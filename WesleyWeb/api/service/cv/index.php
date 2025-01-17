<?php
	
	/* Variables */
	$debug		=	true;
	$secret_Key	=	'$2y$10$b2WWyYaqJDKHLSdw1Jd48.EjDXS6sC9gUXZKidMnlOreFReWl40';
	$key		=	"cv";
	
	/* Archivos base */
	include '../../helper/helper.php';
	include '../../data/cv/index.php';
	/* Cuerpo del API */
	if ($method == 'POST') {
		if(isset($data)){
			$cvResultPost = postCv($data, $mysqli);
			if ($cvResultPost === true) {
				echo '{"status":200,"description":"CV registrado correctamente"}';
			} else {
				echo '{"status":500,"description":"Error al registrar"}';
			}
			die();
		}
	}
	if($method=='GET'){
        $searchResult=searchCV($data,$mysqli);
        echo json_encode($searchResult);
	}	
	if($method=='PUT'){
		if(isset($data)){
			$cvResultPut = putCv($data, $mysqli);
			if ($cvResultPut === true) {
				echo '{"status":200,"description":"Registro actualizado"}';
			} else {
				echo '{"status":500,"description":"Error al actualizar"}';
			}
			die();
		}
	}	
	if ($method == 'DELETE') {
		if(isset($data)){
			$cvResultDelete = deleteCV($data, $mysqli);
			if ($cvResultDelete === true) {
				echo '{"status":200,"description":"Registro eliminado correctamente"}';
			} else {
				echo '{"status":500,"description":"Error al eliminar"}';
			}
			die();
		}
	}
?>