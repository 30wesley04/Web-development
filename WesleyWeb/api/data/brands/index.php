<?php
function getBrands($mysqli){
	$sql 	= "SELECT * FROM marcas;";
	$result = $mysqli -> query($sql);
	if ($result->num_rows) {
        $marcas = array(); // Inicializamos un array para almacenar todas las filas

        while ($row = $result->fetch_assoc()) {
            $marcas[] = $row; // Agregamos cada fila al array
        }
        return ["status" => 200, "brands" => $marcas];
    } else {
        return ["status" => 400, "description" => "Error al recuperar las marcas"];
    }
}
