<?php
session_start();
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
<body style="background-color:#282828; color:white;">

<div class="container my-5 d-flex justify-content-center">
    <div class="p-4 rounded" style="background-color:#333; width: 320px;">
        <h2 class="text-center mb-4">Inicio de sesión</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger py-1 text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="post" action="login.php">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
</div>

</body>
</html>
