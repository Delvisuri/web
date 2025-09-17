<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
session_start();
require_once 'connection.php'; // O "connection.php" si así se llama

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($password, $usuario['password'])) {
                $_SESSION['usuario'] = $usuario['email'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Correo electrónico o contraseña incorrectos.";
            }
        } else {
            $error = "Correo electrónico o contraseña incorrectos.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Iniciar sesión - SIDCDI</title>
  <link rel="stylesheet" href="css/styles.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('img/inventario.png') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 2rem 3rem;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      max-width: 400px;
      width: 100%;
    }

    .login-container h1 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #1e1e2f;
    }

    .login-container label {
      display: block;
      margin-top: 1rem;
      font-weight: bold;
      color: #333;
    }

    .login-container input {
      width: 100%;
      padding: 0.5rem;
      margin-top: 0.3rem;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .login-container button {
      width: 100%;
      padding: 0.7rem;
      margin-top: 1.5rem;
      background-color: #1e1e2f;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-container button:hover {
      background-color: #34345c;
    }

    .login-container p {
      margin-top: 1rem;
      text-align: center;
      color: #444;
    }

    .login-container a {
      color: #1e1e2f;
      text-decoration: none;
      font-weight: bold;
    }

    .login-container a:hover {
      text-decoration: underline;
    }

    #errorMsg {
      color: red;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="login-container">
      <h1>SIDCDI</h1>
      <form id="loginForm" action="login.php" method="POST">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required />

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required />

        <button type="submit">Iniciar sesión</button>
      </form>

      <?php if (!empty($error)) echo "<p id='errorMsg'>$error</p>"; ?>

      <p>¿No tienes cuenta? <a href="register.html">Regístrate</a></p>
      <p>¿Olvidaste tu contraseña? <a href="recovery.html">Recupérala aquí</a></p>
    </div>
  </div>
</body>
</html>




