<?php
function login($data,$mysqli){
	$usuario=$data['usuario'];
	$password=$data['password'];
	$sql 	= "SELECT * FROM usuarios WHERE usuario	='{$usuario}';";
	$result = $mysqli -> query($sql);
	if ($result->num_rows) {
        $usuario = mysqli_fetch_assoc($result);
        $auth = password_verify($password, $usuario['password']);
        $nombreUsuario=$usuario['nombre'];

        if ($auth) {  
            return ["status" => 200, "user" => $usuario];
        } else {
            return ["status" => 400, "description" => "Contraseña incorrecta"];
        }
    } else {
        return ["status" => 400, "description" => "El usuario no existe"];
    }
}
