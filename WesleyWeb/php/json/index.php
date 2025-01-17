<?php

    $jsonTexto='{"nombre":"Wesley","edad":"22","altura":"1.73","sexo":"hombre"}';

    echo "<pre>";
    var_dump ($jsonTexto);
    echo "</pre>";

    $jsonTexto=json_decode($jsonTexto);
    echo "<pre>";
    var_dump ($jsonTexto);
    echo "</pre>";

    $jsonArray=array(
        "nombre"=>"Wesley",
        "edad"=>"22",
        "altura"=>"1.73",
        "sexo"=>"hombre"
    );

    $jsonArray=json_encode($jsonArray);
    echo "<pre>";
    var_dump($jsonArray);
    echo "</pre>";

    $jsonTexto2='{ "marcadores": [ { "latitude": 40.416875, "longitude": -3.703308, "city": "Madrid", "description": "Puerta del Sol" }, { "latitude": 40.417438, "longitude": -3.693363, "city": "Madrid", "description": "Paseo del Prado" }, { "latitude": 40.407015, "longitude": -3.691163, "city": "Madrid", "description": "Estación de Atocha" } ] }';
    $jsonTexto2=json_decode($jsonTexto2,JSON_UNESCAPED_UNICODE);

    echo "<pre>";
    var_dump ($jsonTexto2);
    echo "</pre>";
    
?>