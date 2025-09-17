<?php
// eliminar_producto.php
require_once "connection.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: inventario.php");
        exit;
    } else {
        echo "❌ Error al eliminar: " . $conn->error;
    }
    $stmt->close();
} else {
    header("Location: inventario.php");
    exit;
}
