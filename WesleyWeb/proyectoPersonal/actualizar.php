<?php
    
    require '../api/helper/db.php';
    $idUsuario=$_GET['id'];

    $query="SELECT * FROM curriculum WHERE id='{$idUsuario}';";
    $resultado = $mysqli -> query($query);
    $usuario=mysqli_fetch_assoc($resultado);

    $id=$usuario['id'];
    $nombre=$usuario['nombre'];
    $ciudad=$usuario['ciudad'];
    $pais=$usuario['pais'];
    $edad=$usuario['edad'];
    $profesion=$usuario['profesion'];
    $estado_civil=$usuario['estado_civil'];
    $frase=$usuario['frase'];
    $biografia=$usuario['biografia'];
    $foto=$usuario['foto'];

    $queryB="SELECT * FROM marcas;";
    $resultadoB = $mysqli -> query($queryB);

    $queryT="SELECT * FROM tecnologias;";
    $resultadoT = $mysqli -> query($queryT);
    
    $queryFrustraciones="SELECT * FROM frustraciones WHERE curriculum_id = '{$id}';";
    $resultadoFrustraciones = $mysqli -> query($queryFrustraciones);

    $queryDeseos="SELECT * FROM deseos WHERE curriculum_id = '{$id}';";
    $resultadoDeseos = $mysqli -> query($queryDeseos);


    $queryMarcas="SELECT m.nombre, m.icono,m.id
    FROM curriculum AS c
    JOIN marcas_curriculum AS mc ON c.id = mc.curriculum_id
    JOIN marcas AS m ON mc.marcas_id = m.id
    WHERE c.id = '{$id}';";
    $resultadoMarcas = $mysqli -> query($queryMarcas);

    $queryTech="SELECT t.nombre, ct.calificacion,t.id
    FROM curriculum AS c
    JOIN tecnologias_curriculum AS ct ON c.id = ct.curriculum_id
    JOIN tecnologias AS t ON ct.tecnologias_id = t.id
    WHERE c.id = '{$id}';";
    $resultadoTech = $mysqli -> query($queryTech);
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
    <script defer src="js/functions4.js"></script>
    <script defer src="js/validate.js"></script>
    
    <script src="https://kit.fontawesome.com/6911c1abd9.js" crossorigin="anonymous"></script>
    <title>Actualizar</title>
</head>
<body class="body user__background">
    <form id="formulario-user-persona-actualizar" class="w-100" enctype="multipart/form-data" >
        <div class="contenedor grid">
            <div class="fotografia">
                <input id="input-imagen" type="file" name="imagen" accept="image/jpeg, image/png" style="display: none;">
                <img src="fotosUser/sin_fondo_<?php echo $foto ?>" alt="imgpreview" class="cursorImagen" id="imagen-usuario">
                <div class="frase">
                    <p><input type="text" name="frase" placeholder="Frase" value="<?php echo $frase ?>"></p>
                </div>
            </div>
    
            <div class="informacionPersonal">
                <div class="seccion">
                    <input type="text" name="nombre" placeholder="nombre" class="inputNombre" value="<?php echo $nombre ?>">
                    <div class="informacionPersonal__iconos">
                        <div class="campo-informacion">
                            <i class="fa-solid fa-user"></i>
                            <input type="number" placeholder="Edad" name="edad" min="15" value="<?php echo $edad ?>">
                        </div>
    
                        <div class="campo-informacion">
                            <i class="fa-solid fa-location-dot"></i>
                            <input type="text" placeholder="Ciudad" name="ciudad" value="<?php echo $ciudad ?>">
                        </div>

                        <div class="campo-informacion">
                        <input type="text" placeholder="Pais" name="pais" class="inputPais" value="<?php echo $pais ?>">
                        </div>
                        
    
                        <div class="campo-informacion">
                            <i class="fa-solid fa-briefcase"></i>
                            <input type="text" placeholder="Profesion" name="profesion" value="<?php echo $profesion ?>">
                        </div>
                        
                        <div class="campo-informacion">
                            <i class="fa-solid fa-house"></i>
                            <input type="text" placeholder="Estado civil" name="estado_civil" value="<?php echo $estado_civil ?>">
                        </div>
                    </div>
                </div>
    
                <div class="seccion fondoGris">
                    <h3 class="data-no-linea">Tech</h3>
                    <div class="tecnologias desplegable">
                    <?php $index = 0; ?>
                    <?php while($tecnologia = mysqli_fetch_assoc($resultadoTech)): ?>
                        <div class="tecnologia">
                            <select name="tecnologias_id[]" id="tecnologia<?php echo $index; ?>">
                                <option value="" disabled>--Seleccione--</option>
                                <?php $resultadoT->data_seek(0); // Restablecer el puntero de la consulta de tecnologías ?>
                                <?php while($tecnologiaOpcion = mysqli_fetch_assoc($resultadoT)): ?>
                                    <option value="<?php echo $tecnologiaOpcion['id']; ?>" <?php echo $tecnologiaOpcion['id']===$tecnologia['id'] ? 'selected' : ''; ?> ><?php echo $tecnologiaOpcion['nombre']; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <div class="rating">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" id="tecnologia<?php echo $index; ?>-punto<?php echo $i; ?>" name="calificacion[<?php echo $index; ?>]" value="<?php echo $i; ?>" <?php if ($i == $tecnologia['calificacion']) echo 'checked'; ?>>
                                    <label for="tecnologia<?php echo $index; ?>-punto<?php echo $i; ?>"></label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <?php $index++; ?>
                    <?php endwhile; ?>

                        <button type="button" class="agregarCampo" id="tecnologiaButton">+</button>
                    </div>
                </div>
    
                <div class="seccion">
                    <h3>Bio</h3>
                    <textarea name="biografia" id="biografia"  rows="5" class="w-100" ><?php echo $biografia ?></textarea>
                </div>
    
                <div class="seccion fondoGris">
                    <h3 class="data-no-linea">Favorite Brands</h3>
                    <div class="brands desplegable">
                    <?php $selectedBrands = array(); while ($marcaId = mysqli_fetch_assoc($resultadoMarcas)){$selectedBrands[] = $marcaId['id'];} ?>
                    <?php while($marca = mysqli_fetch_assoc($resultadoB)): ?>
                        <label for="<?php echo $marca['nombre']; ?>" class="brand-label">
                        <!-- in_array(), el primer valor es el valor a buscar dentro del array, y el segundo es el array -->
                            <input <?php echo in_array($marca['id'],$selectedBrands) ? 'checked' :''; ?> type="checkbox" id="<?php echo $marca['nombre']; ?>" name="favoriteBrands[]" value="<?php echo $marca['id']; ?>">
                            <i class="<?php echo $marca['icono']; ?>"></i>
                        </label>
                    <?php endwhile; ?>
                    </div>
                </div>
    
                <div class="seccion">
                    <h3>Wants and Needs</h3>
                    <div class="desplegable" id="needs">
                        <?php while($deseo=mysqli_fetch_assoc($resultadoDeseos)):?>
                         <textarea name="needs[]" class="w-100"><?php echo $deseo['descripcion']; ?></textarea>
                        <?php endwhile;?>
                        <button type="button" class="agregarCampo" id="needsButton">+</button>
                    </div>
                </div>
    
                <div class="seccion">
                    <h3>Frustrations</h3>
                    <div class="desplegable" id="frustrations">
                    <?php mysqli_data_seek($resultadoFrustraciones, 0);?>
                    <?php while($frustracion=mysqli_fetch_assoc($resultadoFrustraciones)):?>
                         <textarea name="frustrations[]" class="w-100"><?php echo $frustracion['descripcion']; ?></textarea>
                        <?php endwhile;?>
                        <button type="button" class="agregarCampo" id="frustrationsButton">+</button>
                    </div>

                    <input type="hidden" name="imagen_anterior" value="<?php echo $foto ?>">
                    <input type="hidden" name="id" value="<?php echo $idUsuario ?>">
                    <input type="submit" value="Actualizar" class="boton-formulario">
                </div>
            </div>
            
        </div>
        
    </form>
</body>
</html>

<!-- tDTu7yNX2EdFaAFqNAwD8ftu -->