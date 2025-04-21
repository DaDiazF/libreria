<?php
require_once('conn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $q = "SELECT id, email, password, nombre FROM usuarios WHERE email = ?";
        $stmt = mysqli_prepare($conn, $q);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultado)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['usuario'] = [
                    'id' => $row['id'],
                    'email' => $row['email'],
                    'nombre' => $row['nombre']
                ];
                echo "<script>
                    alert('Inicio de sesión exitoso. Bienvenido {$row['nombre']}');
                    location.href = 'index.php';
                </script>";
            } else {
                echo "<script>
                    alert('Contraseña incorrecta. Inténtalo nuevamente.');
                    location.href = 'login.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('No existe una cuenta registrada con este correo.');
                location.href = 'login.php';
            </script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>
            alert('Por favor completa todos los campos.');
            location.href = 'login.php';
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="nav">

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-5" style="width: 100%; max-width: 550px;">
    <h2 class="text-center mb-4">Iniciar sesión</h2> 
    <form method="POST">
      <div class="mb-4">
        <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Correo electrónico" required>
      </div>
      <div class="mb-4">
        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Contraseña" required>
      </div>
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-lg" id="nav">Ingresar</button>
      </div>
      <div class="d-grid mb-3">
        <a href="index.html" class="btn btn-secondary btn-lg">Regresar</a>
      </div>
    </form>
    <div class="text-center mt-3">
      <a href="#" class="d-block mb-2">¿Olvidaste tu contraseña?</a>
      <p>¿No tienes cuenta? <a href="sign.php">Regístrate aquí</a></p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
