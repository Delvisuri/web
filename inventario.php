<?php
// inventario.php
require_once "connection.php";

// Consultar todos los productos
$sql = "SELECT id, nombre, descripcion, cantidad, precio FROM productos ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Inventario - SIDCDI</title>
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
      max-width: 1000px;
      width: 95%;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      text-align: center;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    a.btn-volver {
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
    a.btn-volver:hover {
      background-color: #5a6268;
    }
    a.btn-editar {
      display: inline-block;
      padding: 6px 15px;
      background-color: #ffc107;
      color: #212529;
      font-weight: bold;
      border-radius: 6px;
      text-decoration: none;
    }
    a.btn-editar:hover {
      background-color: #e0a800;
    }
    a.btn-eliminar {
      display: inline-block;
      padding: 6px 15px;
      background-color: #dc3545;
      color: white;
      font-weight: bold;
      border-radius: 6px;
      text-decoration: none;
    }
    a.btn-eliminar:hover {
      background-color: #c82333;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Inventario de Productos</h2>

    <?php if ($result && $result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['nombre']) ?></td>
              <td><?= htmlspecialchars($row['descripcion']) ?></td>
              <td><?= $row['cantidad'] ?></td>
              <td>$<?= number_format($row['precio'], 2) ?></td>
              <td>
                <a class="btn-editar" href="editar_producto.php?id=<?= $row['id'] ?>">Editar</a>
                <a class="btn-eliminar" href="eliminar_producto.php?id=<?= $row['id'] ?>"
                   onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No hay productos registrados.</p>
    <?php endif; ?>

    <a href="dashboard.php" class="btn-volver">Volver</a>
  </div>
</body>
</html>
