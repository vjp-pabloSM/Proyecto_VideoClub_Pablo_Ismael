<?php
session_start();

// Obtiene mensaje de error de la sesión si hubiese
$error = $_SESSION['error'] ?? "";
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Videoclub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
.shadow-custom {
    box-shadow: 0px 0px 20px rgba(0, 0, 255, 0.15);
}
</style>
<body class="bg-dark text-white">

    <!-- Contenedor principal -->
    <div class="container my-5 d-flex justify-content-center">
        <!-- Caja del formulario -->
        <div class="p-4 rounded shadow-custom" style="background-color:#333; width: 320px;">
            <h2 class="text-center mb-4">Inicio de sesión</h2>

            <!-- Mostrar mensaje de error -->
            <?php if ($error): ?>
                <div class="alert alert-danger py-1 text-center"><?= $error ?></div>
            <?php endif; ?>

            <!-- Formulario de login -->
            <form method="post" action="login.php">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <!-- Botón -->
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
