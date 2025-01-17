<?php
    function conexion(){
        $mysqli = new mysqli("localhost","user7","user7","user7");
        if ($mysqli -> connect_errno) {
          echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
          exit();
        }
        return $mysqli;
    }