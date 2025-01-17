<?php
/***************** CURL **************/
function curl($url,$post,$auth,$metodo){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => $metodo,
	  CURLOPT_POSTFIELDS => json_encode($post),
	  CURLOPT_HTTPHEADER => array(
	   'Content-Type: application/json',
	   'Authorization: Bearer '.$auth
	  ),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	if($response=json_decode($response)){
		$response=json_encode($response);
		echo $response;
	}else{
		echo '{"status":502,"description":"Error de API"}';
	}
}
/********** Función para validar correo electrónico **********/
function is_valid_email($str){
  $result = (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
  if ($result){
    list($user, $domain) = explode('@', $str);
    $result = checkdnsrr($domain, 'MX');
  }
  return $result;
}