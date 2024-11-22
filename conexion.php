<?php
// Datos de conexión a la base de datos
$host = 'localhost'; // O el servidor de tu base de datos
$usuario = 'root'; // Tu usuario de base de datos
$clave = ''; // Tu contraseña de base de datos
$nombre_bd = 'once_inicial_db'; // El nombre de tu base de datos

// Crear la conexión
$conexion = mysqli_connect($host, $usuario, $clave, $nombre_bd);

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
