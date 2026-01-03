<?php
require __DIR__ . '/vendor/autoload.php';
session_start();

// Si no hay usuario logueado, redirige al login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Obtener el usuario logueado
$user = $_SESSION['user'];

// Si el usuario es admin, redirige al panel de administrador
if ($user === 'admin') {
    header("Location: mainAdmin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel principal - Videoclub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white d-flex justify-content-center align-items-center" style="height:100vh">
    <div class="text-center">
        <h2 class="mb-4">Bienvenido, <?= htmlspecialchars($user) ?></h2>

        <a href="mainCliente.php" class="btn btn-outline-primary mb-2 w-100">
            Ver mis alquileres
        </a>

        <a href="logout.php" class="btn btn-outline-danger w-100">
            Cerrar sesión
        </a>
    </div>
</body>
</html>
