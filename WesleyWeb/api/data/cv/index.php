<?php
function postCv($data,$mysqli){
    $imagen = $data['foto'];
    $frase=$data['frase'];
	$nombre=$data['nombre'];
	$edad=$data['edad'];
    $ciudad=$data['ciudad'];
	$pais=$data['pais'];
    $profesion=$data['profesion'];
	$estado_civil=$data['estado_civil'];
    $tecnologias_id=$data['tecnologias_id'];
	$calificacion=$data['calificacion'];
    $biografia=$data['biografia'];
	$favoriteBrands=$data['favoriteBrands'];
    $needs=$data['needs'];
	$frustrations=$data['frustrations'];

    $operacionesExitosas=true;
    

    $sql 	= "INSERT INTO curriculum (nombre,ciudad,pais,edad,profesion,estado_civil,frase,biografia,foto) 
                                VALUES('{$nombre}','{$ciudad}','{$pais}','{$edad}','{$profesion}','{$estado_civil}','{$frase}','{$biografia}','{$imagen}');";
	$result = $mysqli -> query($sql);
    $idCV = $mysqli->insert_id;

    foreach ($favoriteBrands as $marcaId) {
        $queryInsertMarcas = "INSERT INTO marcas_curriculum (curriculum_id, marcas_id) VALUES ('$idCV', '$marcaId');";
        $resultadoInsertMarcas = $mysqli->query($queryInsertMarcas);
        if(!$resultadoInsertMarcas){
            $operacionesExitosas=false;
        }
    }

    foreach ($tecnologias_id as $index => $tecnologiaId) {
        $queryInsertTech = "INSERT INTO tecnologias_curriculum (curriculum_id, tecnologias_id, calificacion) 
            VALUES ('$idCV', '$tecnologiaId', '{$calificacion[$index]}');";
        $resultadoInsertTech = $mysqli->query($queryInsertTech);
        if(!$resultadoInsertTech){
            $operacionesExitosas=false;
        }
    }

    foreach ($needs as $deseo) {
        $queryInsertNeeds = "INSERT INTO deseos (curriculum_id, descripcion) VALUES ('$idCV', '$deseo');";
        $resultadoInsertNeeds = $mysqli->query($queryInsertNeeds);
        if(!$resultadoInsertNeeds){
            $operacionesExitosas=false;
        }
    }
    foreach ($frustrations as $frustracion) {
        $queryInsertFrustrations = "INSERT INTO frustraciones (curriculum_id, descripcion) VALUES ('$idCV', '$frustracion');";
        $resultadoInsertFrustrations = $mysqli->query($queryInsertFrustrations);
        if(!$resultadoInsertFrustrations){
            $operacionesExitosas=false;
        }
    }

    if($operacionesExitosas){
        return true;
    }else{
        return false;
    }


}

function searchCV($data, $mysqli) {
    $searchTerm = isset($data['search']) ? $data['search'] : '';
    $searchCondition = $searchTerm !== '' ? "WHERE nombre LIKE '%$searchTerm%'" : '';

    $query = "SELECT DISTINCT * FROM curriculum $searchCondition";
    $result = $mysqli->query($query);

    if ($result->num_rows) {
        $curriculum = array();

        while ($row = $result->fetch_assoc()) {
            $curriculum[] = $row;
        }

        // Eliminar duplicados 
        $curriculum = array_unique($curriculum, SORT_REGULAR);

        return ["status" => 200, "curriculum" => $curriculum];
    } else {
        return ["status" => 400, "description" => "Error al recuperar las marcas"];
    }
}


function deleteCV($data, $mysqli) {
    
    $id = $data['id'];
    $queryMarcas ="DELETE FROM marcas_curriculum WHERE curriculum_id ='{$id}';";
    $resultMarcas = $mysqli -> query($queryMarcas);

    $queryTecnologias ="DELETE FROM tecnologias_curriculum WHERE curriculum_id ='{$id}';";
    $resultTecnologias = $mysqli -> query($queryTecnologias);

    $queryDeseos ="DELETE FROM deseos WHERE curriculum_id ='{$id}';";
    $resultDeseos = $mysqli -> query($queryDeseos);

    $queryFrustraciones ="DELETE FROM frustraciones WHERE curriculum_id ='{$id}';";
    $resultFrustraciones = $mysqli -> query($queryFrustraciones);
    if($queryDeseos && $queryFrustraciones){
        $query = "DELETE FROM curriculum WHERE id = '{$id}';";
        $result = $mysqli -> query($query);
        if($result){
            return true;
        }
    }

}



function putCv($data, $mysqli) {
    $idCV = $data['id'];
    $imagen = $data['foto'];
    $frase=$data['frase'];
	$nombre=$data['nombre'];
	$edad=$data['edad'];
    $ciudad=$data['ciudad'];
	$pais=$data['pais'];
    $profesion=$data['profesion'];
	$estado_civil=$data['estado_civil'];
    $tecnologias_id=$data['tecnologias_id'];
	$calificacion=$data['calificacion'];
    $biografia=$data['biografia'];
	$favoriteBrands=$data['favoriteBrands'];
    $needs=$data['needs'];
	$frustrations=$data['frustrations'];

    $operacionesExitosas=true;
    

    $sql = "UPDATE curriculum SET nombre='{$nombre}', ciudad='{$ciudad}', pais='{$pais}', edad='{$edad}', profesion='{$profesion}', estado_civil='{$estado_civil}', frase='{$frase}', biografia='{$biografia}',foto='{$imagen}' WHERE id='{$idCV}'";
    $result = $mysqli->query($sql);

    $queryDeleteMarcas = "DELETE FROM marcas_curriculum WHERE curriculum_id = '$idCV';";
    $resultadoDeleteMarcas = $mysqli->query($queryDeleteMarcas);
    foreach ($favoriteBrands as $marcaId) {
        $queryInsertMarcas = "INSERT INTO marcas_curriculum (curriculum_id, marcas_id) VALUES ('$idCV', '$marcaId');";
        $resultadoInsertMarcas = $mysqli->query($queryInsertMarcas);
        if(!$resultadoInsertMarcas){
            $operacionesExitosas=false;
        }
    }

    $queryDeleteTech = "DELETE FROM tecnologias_curriculum WHERE curriculum_id = '$idCV';";
    $resultadoDeleteTech = $mysqli->query($queryDeleteTech);
    foreach ($tecnologias_id as $index => $tecnologiaId) {
        $queryInsertTech = "INSERT INTO tecnologias_curriculum (curriculum_id, tecnologias_id, calificacion) 
            VALUES ('$idCV', '$tecnologiaId', '{$calificacion[$index]}');";
        $resultadoInsertTech = $mysqli->query($queryInsertTech);
        if(!$resultadoInsertTech){
            $operacionesExitosas=false;
        }
    }

    $queryDeleteNeeds = "DELETE FROM deseos WHERE curriculum_id = '$idCV';";
    $resultadoDeleteNeeds = $mysqli->query($queryDeleteNeeds);
    foreach ($needs as $deseo) {
        $queryInsertNeeds = "INSERT INTO deseos (curriculum_id, descripcion) VALUES ('$idCV', '$deseo');";
        $resultadoInsertNeeds = $mysqli->query($queryInsertNeeds);
        if(!$resultadoInsertNeeds){
            $operacionesExitosas=false;
        }
    }

    $queryDeleteFrustrations = "DELETE FROM frustraciones WHERE curriculum_id = '$idCV';";
    $resultadoDeleteFrustrations = $mysqli->query($queryDeleteFrustrations);
    foreach ($frustrations as $frustracion) {
        $queryInsertFrustrations = "INSERT INTO frustraciones (curriculum_id, descripcion) VALUES ('$idCV', '$frustracion');";
        $resultadoInsertFrustrations = $mysqli->query($queryInsertFrustrations);
        if(!$resultadoInsertFrustrations){
            $operacionesExitosas=false;
        }
    }

    if($operacionesExitosas){
        return true;
    }else{
        return false;
    }


}



