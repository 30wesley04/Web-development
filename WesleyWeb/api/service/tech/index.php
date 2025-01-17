<?php
	
	/* Variables */
	$debug		=	true;
	$secret_Key	=	'$2y$10$b2WWyYaqJDKHLSdw1Jd48.EjDXS6sC9gUXZKidMnlOreFReWl40';
	$key		=	"tech";
	
	/* Archivos base */
	include '../../helper/helper.php';
	include '../../data/tech/index.php';

	/* Cuerpo del API */
	if ($method == 'POST') {
	}
	if($method=='GET'){
	   $techResult=getTech($mysqli);
       echo json_encode($techResult);

	}	
	if($method=='PUT'){
	
	}	
	if($method=='DELETE'){
	
	}
?>