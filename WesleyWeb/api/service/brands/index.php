<?php
	
	/* Variables */
	$debug		=	true;
	$secret_Key	=	'$2y$10$b2WWyYaqJDKHLSdw1Jd48.EjDXS6sC9gUXZKidMnlOreFReWl40';
	$key		=	"brands";
	
	/* Archivos base */
	include '../../helper/helper.php';
	include '../../data/brands/index.php';

	/* Cuerpo del API */
	if ($method == 'POST') {

	}
	if($method=='GET'){
	   $brandResult=getBrands($mysqli);
       echo json_encode($brandResult);

	}	
	if($method=='PUT'){
	
	}	
	if($method=='DELETE'){
	
	}
?>