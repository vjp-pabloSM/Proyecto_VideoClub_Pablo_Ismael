<?php
session_start();

// Redirige al index si el usuario no es admin
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="IsmaelGJ">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Crear Cliente - Videoclub</title>
</head>
<style>
    .shadow-custom {
        box-shadow: 0px 0px 20px rgba(0, 0, 255, 0.15);
    }
</style>

<body class="bg-dark text-white">
    <div class="container my-5 d-flex justify-content-center">
        <!-- Contenedor principal del formulario -->
        <div class="p-4 rounded shadow-custom" style="background-color:#333; width: 360px;">
            <h2 class="text-center mb-4">Crear Nuevo Cliente</h2>

            <!-- Mensaje de error -->
            <?php
            if (!empty($_SESSION['error'])) {
                echo '<div class="alert alert-danger py-1 text-center">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']); // Limpiar error para que no aparezca de nuevo
            }
            ?>

            <!-- Formulario para crear cliente -->
            <form action="createCliente.php" method="post">
                <div class="mb-3">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Usuario:</label>
                    <input type="text" name="user" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Contraseña:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <!-- Botones -->
                <div class="d-flex">
                    <button type="submit" class="btn btn-outline-primary w-50 me-2">Crear Cliente</button>
                    <a href="mainAdmin.php" class="btn btn-outline-danger w-50">Volver</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
