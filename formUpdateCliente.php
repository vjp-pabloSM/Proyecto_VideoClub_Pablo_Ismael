<?php
require_once __DIR__ . "/app/Cliente.php";
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;

session_start();

// Recoge ID si existe
$id = $_GET['id'] ?? null;
$cliente = null;

// Si es ADMIN y hay ID, buscar el cliente correspondiente en la sesión
if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin' && $id !== null && !empty($_SESSION['clientes'])) {
    foreach ($_SESSION['clientes'] as $c) {
        if ($c instanceof Cliente && $c->getNumero() == $id) {
            $cliente = $c;
            break;
        }
    }
}
// Si es cliente normal, usar su propia sesión
elseif (isset($_SESSION['cliente_actual'])) {
    $cliente = $_SESSION['cliente_actual'];
}

// Si no se encontró un cliente válido, redirige
if ($cliente === null) {
    header("Location: main.php");
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
    <title>Actualizar Cliente - Videoclub</title>
</head>
<style>
.shadow-custom {
    box-shadow: 0px 0px 20px rgba(0, 0, 255, 0.15);
}
</style>
<body class="bg-dark text-white">

    <!-- Contenedor principal -->
    <div class="container my-5 w-25 p-4 rounded shadow-custom" style="background-color:#333; width: 360px;">
        <h2 class="mb-4 text-center">Actualizar Cliente</h2>

        <!-- Mostrar mensaje de error -->
        <?php if (!empty($_SESSION['error'])): ?>
            <p class="text-danger"><?= $_SESSION['error'] ?></p>
            <?php unset($_SESSION['error']);?>
        <?php endif; ?>

        <!-- Formulario de actualización de cliente -->
        <form action="updateCliente.php" method="post">
            <!-- ID oculto para identificar qué cliente actualizar -->
            <input type="hidden" name="id" value="<?= $cliente->getNumero() ?>">
            <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($cliente->nombre) ?>" required>
            </div>
            <div class="mb-3">
                <label>Usuario:</label>
                <input type="text" name="user" class="form-control" value="<?= htmlspecialchars($cliente->getUser()) ?>" required>
            </div>
            <div class="mb-3">
                <label>Contraseña:</label>
                <input type="text" name="password" class="form-control" value="<?= htmlspecialchars($cliente->getPassword()) ?>" required>
            </div>

            <!-- Botones -->
            <div class="d-flex">
                <button type="submit" class="btn btn-outline-primary w-50 me-2">Guardar cambios</button>
                <a href="<?= $_SESSION['user']==='admin' ? 'mainAdmin.php' : 'mainCliente.php' ?>" class="btn btn-outline-danger w-50">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
