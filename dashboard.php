<?php
// dashboard.php
require_once "connection.php";

$mensaje = "";

// Mostrar mensaje éxito si viene por GET
if (isset($_GET['exito']) && $_GET['exito'] == '1') {
    $mensaje = "✅ Producto guardado correctamente.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $cantidad = (int)($_POST['cantidad'] ?? 0);
    $precio = (float)($_POST['precio'] ?? 0);

    if ($nombre && $descripcion && $cantidad > 0 && $precio > 0) {
        $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssid", $nombre, $descripcion, $cantidad, $precio);
        if ($stmt->execute()) {
            // Redirigir a la misma página con parámetro para mostrar éxito
            header("Location: dashboard.php?exito=1");
            exit();
        } else {
            $mensaje = "❌ Error al guardar: " . $conn->error;
        }
        $stmt->close();
    } else {
        $mensaje = "⚠️ Todos los campos son obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Crear Producto - SIDCDI</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: url('img/inventario.png') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding-top: 60px;
    }
    .container {
      background: rgba(255, 255, 255, 0.9);
      max-width: 500px;
      width: 90%;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      text-align: center;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }
    .success-message {
      background-color: #d1e7dd;
      color: #0f5132;
      padding: 15px 25px;
      border-radius: 8px;
      margin-bottom: 25px;
      font-weight: bold;
      font-size: 1.1rem;
      border: 1.5px solid #badbcc;
    }
    .error-message {
      background-color: #f8d7da;
      color: #842029;
      padding: 15px 25px;
      border-radius: 8px;
      margin-bottom: 25px;
      font-weight: bold;
      font-size: 1.1rem;
      border: 1.5px solid #f5c2c7;
    }
    label {
      display: block;
      text-align: left;
      margin-top: 15px;
      font-weight: 600;
      color: #333;
    }
    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }
    button[type="submit"] {
      margin-top: 25px;
      padding: 14px 0;
      width: 100%;
      background-color: #007bff;
      border: none;
      color: white;
      font-weight: bold;
      font-size: 1.1rem;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button[type="submit"]:hover {
      background-color: #0056b3;
    }
    a.btn-inventario {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 30px;
      background-color: #6c757d;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    a.btn-inventario:hover {
      background-color: #5a6268;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Crear Producto</h2>

    <?php if ($mensaje): ?>
      <div class="<?= strpos($mensaje, '✅') === 0 ? 'success-message' : 'error-message' ?>">
        <?= $mensaje ?>
      </div>
    <?php endif; ?>

    <form method="post" autocomplete="off">
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" required />

      <label for="descripcion">Descripción:</label>
      <input type="text" id="descripcion" name="descripcion" required />

      <label for="cantidad">Cantidad:</label>
      <input type="number" id="cantidad" name="cantidad" min="1" required />

      <label for="precio">Precio:</label>
      <input type="number" id="precio" name="precio" step="0.01" min="0.01" required />

      <button type="submit">Crear Producto</button>
    </form>

    <a href="inventario.php" class="btn-inventario">Ir a Inventario</a>
  </div>
</body>
</html>
