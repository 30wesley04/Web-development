<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mysqli = new mysqli("localhost","user7","user7","user7");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$sql = "SELECT * FROM mi_tabla";
$result = $mysqli -> query($sql);

// Número array
$row = $result -> fetch_array(MYSQLI_NUM);
printf ("%s (%s)\n", $row[0], $row[1]);

// Campo array
$row = $result -> fetch_array(MYSQLI_ASSOC);
printf ("%s (%s)\n", $row["nombre"], $row["nacimiento"]);


$row = json_encode($result -> fetch_array(MYSQLI_ASSOC));
echo "<pre>";
var_dump($row);
echo "</pre>";	
$row = json_decode($row);
echo "<pre>";
var_dump($row);
echo "</pre>";

echo "El id es $row->id ";
echo 'El nombre es '. $row->nombre;

// Free result set
$result -> free_result();

$mysqli -> close();