<?php
session_start(); // Asegura el uso de sesiones

require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    // Validar campos
    if (empty($email) || empty($pass)) {
        die("Faltan datos obligatorios.");
    }

    // Consulta segura
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $pass); // ss = string, string

    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        // Usuario encontrado
        $usuario = $resultado->fetch_assoc();
        $_SESSION['usuario'] = $usuario['email'];

        // Redireccionar al dashboard
        header("Location: dashboard.php");
        exit; // Siempre después de un header
    } else {
        echo "Correo o contraseña incorrectos.";
    }

    $stmt->close();
}

$conn->close();
?>
