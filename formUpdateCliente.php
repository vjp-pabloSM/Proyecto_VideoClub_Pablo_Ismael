<?php
require __DIR__ . '/vendor/autoload.php';
session_start();

// Obtener ID si viene por GET
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$cliente = null;

// ADMIN editando un cliente concreto
if (
    isset($_SESSION['user']) &&
    $_SESSION['user'] === 'admin' &&
    $id !== null &&
    !empty($_SESSION['clientes'])
) {
    foreach ($_SESSION['clientes'] as $c) {
        if ($c['numero'] == $id) {
            $cliente = $c;
            break;
        }
    }
}
// CLIENTE editándose a sí mismo
elseif (isset($_SESSION['cliente_actual'])) {
    $cliente = $_SESSION['cliente_actual'];
}

// Si no hay cliente válido → fuera
if ($cliente === null) {
    header("Location: mainAdmin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Cliente - Videoclub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
.shadow-custom {
    box-shadow: 0px 0px 20px rgba(0, 0, 255, 0.15);
}
</style>

<body class="bg-dark text-white">

<div class="container my-5 d-flex justify-content-center">
    <div class="p-4 rounded shadow-custom" style="background-color:#333; width: 360px;">

        <h2 class="mb-4 text-center">Actualizar Cliente</h2>

        <!-- Mensaje de error -->
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="updateCliente.php" method="post">

            <input type="hidden" name="id" value="<?= $cliente['numero'] ?>">

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text"
                    name="nombre"
                    class="form-control"
                    value="<?= htmlspecialchars($cliente['nombre'] ?? '') ?>"
                    required>
            </div>

            <div class="mb-3">
                <label>Usuario</label>
                <input type="text"
                    name="user"
                    class="form-control"
                    value="<?= htmlspecialchars($cliente['user'] ?? '') ?>"
                    required>
            </div>

            <div class="mb-3">
                <label>Contraseña</label>
                <input type="text"
                    name="password"
                    class="form-control"
                    value="<?= htmlspecialchars($cliente['password'] ?? '') ?>"
                    required>
            </div>

            <div class="d-flex">
                <button type="submit" class="btn btn-outline-primary w-50 me-2">
                    Guardar
                </button>

                <a href="<?= $_SESSION['user'] === 'admin'
                    ? 'mainAdmin.php'
                    : 'mainCliente.php' ?>"
                    class="btn btn-outline-danger w-50">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

</body>
</html>
