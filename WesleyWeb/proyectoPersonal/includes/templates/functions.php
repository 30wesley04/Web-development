<?php

 function estaAutenticado(){
    session_start();
    $logeado=$_SESSION['login'];
    $auth=$_SESSION['jwt'];
    $usuario=$_SESSION['usuario'];
    if($auth && $usuario && $logeado){
        return true;
    }

    return false;
 }