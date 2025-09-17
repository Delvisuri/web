<?php
// Datos de conexión a InfinityFree
$host = "sql305.infinityfree.com"; // Host MySQL
$user = "if0_39658012";           // Usuario MySQL
$pass = "Saua2012";          // Contraseña MySQL
$db   = "if0_39658012_sidcdi_db"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

  