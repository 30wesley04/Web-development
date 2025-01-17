<?php
	
	/* Variables */
	$debug		=	true;
	$secret_Key	=	'$2y$10$b2WWyYaqJDKHLSdw1Jd48.EjDXS6sC9gUXZKidMnlOreFReWl40';
	$key		=	"loginProyecto";
	
	/* Archivos base */
	include '../../helper/helper.php';
	include '../../data/login/index.php';

	/* Cuerpo del API */
	if ($method == 'POST') {
		if (isset($data)) {
			$loginResult = login($data, $mysqli);
			
			if ($loginResult === true) {
				echo json_encode($loginResult);
			} else {
				echo json_encode($loginResult);
			}
			die();
		} else {
			echo '{"status": 400, "description": "Datos de entrada no válidos"}';
			die();
		}
	}
	if($method=='GET'){
	
	}	
	if($method=='PUT'){
	
	}	
	if($method=='DELETE'){
	
	}
?>