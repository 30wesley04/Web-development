<?php
function getTech($mysqli){
	$sql 	= "SELECT * FROM tecnologias;";
	$result = $mysqli -> query($sql);
	if ($result->num_rows) {
        $tecnologias = array(); 

        while ($row = $result->fetch_assoc()) {
            $tecnologias[] = $row; 
        }
        return ["status" => 200, "tech" => $tecnologias];
    } else {
        return ["status" => 500, "description" => "Error al recuperar las tecnologias"];
    }
}
