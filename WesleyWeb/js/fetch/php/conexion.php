<?php
    function conexion(){
        $mysqli = new mysqli("localhost","user7","user7","user7");
        if ($mysqli -> connect_errno) {
          echo "error de conexion";
          exit();
        }
        return $mysqli;
    }