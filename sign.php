<?php
require_once('conn.php'); 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['nombre']) &&
        isset($_POST['email']) &&
        isset($_POST['password']) &&
        isset($_POST['confirmar_password']) &&
        isset($_POST['direccion']) &&
        isset($_POST['telefono'])
    ) {
        $nombre = trim($_POST['nombre']);
        $email = trim($_POST['email']); 
        $password = trim($_POST['password']);
        $confirmar_password = trim($_POST['confirmar_password']);
        $direccion = trim($_POST['direccion']);
        $telefono = trim($_POST['telefono']);

        if ($password === $confirmar_password) {

            $q = "SELECT COUNT(*) AS contar FROM usuarios WHERE email = ?";
            $stmt = mysqli_prepare($conn, $q);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            $array = mysqli_fetch_array($resultado);

            if ($array['contar'] > 0) {
                echo "<script> alert('Este correo ya está registrado.'); location.href = 'sign.php'; </script>";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insertar el nuevo usuario
                $insert_query = "INSERT INTO usuarios (nombre, email, password, direccion, telefono) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $insert_query);
                mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $hashed_password, $direccion, $telefono);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<script> alert('Registro exitoso. Ahora puedes iniciar sesión.'); location.href = 'index.php'; </script>";
                } else {
                    echo "<script> alert('Error al registrar el usuario: " . mysqli_error($conn) . "'); location.href = 'sign.php'; </script>";
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script> alert('Las contraseñas no coinciden. Intenta nuevamente.'); location.href = 'sign.php'; </script>";
        }
    } else {
        echo "<script> alert('Por favor completa todos los campos.'); location.href = 'sign.php'; </script>";
    }
}
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrarse</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="nav">

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-5" style="width: 100%; max-width: 550px;">
    <h2 class="text-center mb-4">Registrarse</h2>
    <form method="POST" id="registroForm">
      <div class="mb-4">
        <input type="text" name="nombre" id="nombre" class="form-control form-control-lg" placeholder="Nombre" required>
      </div>
      <div class="mb-4">
        <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Correo electrónico" required>
      </div>
      <div class="mb-4">
      <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Contraseña" required 
       minlength="8" 
       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$" 
       title="La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.">

      </div>
      <div class="mb-4">
        <input type="password" name="confirmar_password" id="confirmar_password" class="form-control form-control-lg" placeholder="Confirmar contraseña" required>
      </div>
      <div class="mb-4">
        <input type="text" name="direccion" id="direccion" class="form-control form-control-lg" placeholder="Dirección" required>
      </div>
      <div class="mb-4">
        <input type="number" name="telefono" id="telefono" class="form-control form-control-lg" placeholder="Teléfono" required>
      </div>
      <div class="mb-4">
        <div class="col"> 
            <input type="checkbox" required> Acepto términos y condiciones.
        </div>
      </div>
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Registrarse</button>
      </div>
      <div class="d-grid mb-3">
        <a href="index.html" class="btn btn-secondary btn-lg">Regresar</a>
      </div>
    </form>
    <div class="text-center mt-3">
      <p>¿Ya tienes una cuenta? <a href="login.php">Ingresa aquí.</a></p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
