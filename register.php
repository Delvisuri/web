<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmar = trim($_POST['confirmar'] ?? '');

    if (empty($nombre) || empty($email) || empty($password) || empty($confirmar)) {
        die("Todos los campos son obligatorios.");
    }

    if ($password !== $confirmar) {
        die("Las contraseñas no coinciden.");
    }

    // Verificar si el correo ya existe
    $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Este correo ya está registrado.");
    }

    $stmt->close();

    // Encriptar la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO user (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $passwordHash);

    if ($stmt->execute()) {
    header("Location: login.php?registro=ok");
    exit;
    } else {
        echo "Error al registrar usuario.";
    }

    $stmt->close();
    $conn->close();
}
?>
