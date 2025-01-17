<?php
    
    require '../api/helper/db.php';
    session_start();
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


    
    $queryFrustraciones="SELECT * FROM frustraciones WHERE curriculum_id = '{$id}';";
    $resultadoFrustraciones = $mysqli -> query($queryFrustraciones);

    $queryDeseos="SELECT * FROM deseos WHERE curriculum_id = '{$id}';";
    $resultadoDeseos = $mysqli -> query($queryDeseos);

    $queryMarcas="SELECT marcas.nombre AS nombre_marca, marcas.icono AS icono_marca
    FROM curriculum
    JOIN marcas_curriculum ON curriculum.id = marcas_curriculum.curriculum_id
    JOIN marcas ON marcas_curriculum.marcas_id = marcas.id
    WHERE curriculum.id = '{$id}';";
    $resultadoMarcas = $mysqli -> query($queryMarcas);

    $queryTech="SELECT t.nombre, ct.calificacion
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
    <script src="https://kit.fontawesome.com/6911c1abd9.js" crossorigin="anonymous"></script>
    <title>User Persona</title>
</head>
<body class="body user__background">
    <div class="contenedor grid">
        <div class="fotografia">
            <img src="fotosUser/sin_fondo_<?php echo $foto ?>" alt="fotoUserPersona">
            <div class="frase">
                <p><?php echo $frase?></p>
            </div>
        </div>

        <div class="informacionPersonal">
            <div class="seccion">
                <h2><?php echo $nombre?></h2>
                <div class="informacionPersonal__iconos">
                        <div class="campo-informacion">
                            <i class="fa-solid fa-user"></i>
                            <p><?php echo $edad?></p>
                        </div>
    
                        <div class="campo-informacion">
                            <i class="fa-solid fa-location-dot"></i>
                            <p><?php echo $ciudad.", ".$pais ?></p>
                        </div>
                        
    
                        <div class="campo-informacion">
                            <i class="fa-solid fa-briefcase"></i>
                            <p><?php echo $profesion?></p>
                        </div>
                        
                        <div class="campo-informacion">
                            <i class="fa-solid fa-house"></i>
                            <p><?php echo $estado_civil?></p>
                        </div>
                    </div>
            </div>

            <div class="seccion fondoGris">
                <h3 class="data-no-linea">Tech</h3>
                <div class="tecnologias desplegable">
                <?php while ($tech = mysqli_fetch_assoc($resultadoTech)): ?>
                    <div class="tecnologia">
                        <p><?php echo $tech['nombre']; ?></p>
                        <div class="rating">
                            <?php
                            $calificacion = $tech['calificacion'];

                            for ($i = 5; $i >= 1; $i--) {
                                $idRadio = "tecnologia{$i}-{$tech['nombre']}-rating";
                            ?>
                                <input type="radio" id="<?php echo $idRadio; ?>" name="<?php echo $tech['nombre']; ?>-rating" value="<?php echo "{$tech['nombre']}-{$i}"; ?>" <?php echo $i == $calificacion ? 'checked' : ''; ?> disabled>
                                <label for="<?php echo $idRadio; ?>"></label>
                            <?php } ?>
                        </div>
                    </div>
                <?php endwhile; ?>

                </div>
            </div>

            <div class="seccion">
                <h3>Bio</h3>
                <p><?php echo $biografia?></p>
            </div>

            <div class="seccion fondoGris">
                <h3 class="data-no-linea">Favorite Brands</h3>
                <div class="brands desplegable">
                    <?php while($marca=mysqli_fetch_assoc($resultadoMarcas)): ?>
                        <i class="<?php echo $marca['icono_marca'] ?>"></i>
                    <?php endwhile; ?>
                    
                </div>
            </div>

            <div class="seccion">
                <h3>Wants and Needs</h3>
                <ul class="desplegable">
                    <?php while($deseo=mysqli_fetch_assoc($resultadoDeseos)): ?>
                        <li><?php echo $deseo['descripcion']; ?></li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <div class="seccion">
                <h3>Frustrations</h3>
                <ul class="desplegable">
                <?php while($frustracion=mysqli_fetch_assoc($resultadoFrustraciones)): ?>
                    <li><?php echo $frustracion['descripcion']; ?></li>
                <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </div>
    
</body>
</html>