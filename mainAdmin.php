<?php
require_once __DIR__ . "/app/Cliente.php";
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;

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
    <title>Panel Administrador - Videoclub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
.alert {
    transition: opacity 0.5s ease-in-out;
}
.alert.fade-out {
    opacity: 0;
}
.shadow-custom {
    box-shadow: 0px 0px 20px rgba(0, 0, 255, 0.15);
}
</style>
<body class="bg-dark text-white">
    <div class="container my-5 w-50">
        <h1 class="mb-4">Bienvenido Administrador</h1>

        <!-- Mensaje de éxito -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert border border-success text-success rounded py-2 px-3 w-75" role="alert">
                <?= $_SESSION['mensaje'] ?>
            </div>
            <?php unset($_SESSION['mensaje']);?>
        <?php endif; ?>

        <!-- Mensaje de error -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert border border-danger text-danger rounded py-2 px-3 w-75" role="alert">
                <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']);?>
        <?php endif; ?>

        <!-- Lista de clientes -->
        <h4>Listado de clientes</h4>
        <?php if (!empty($_SESSION['clientes'])): ?>
            <ul class="list-group mb-4 shadow-custom">
                <?php foreach ($_SESSION['clientes'] as $cliente): ?>
                    <?php if ($cliente instanceof Cliente): ?>
                        <li class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">
                            <!-- Nombre y usuario del cliente -->
                            <span><?= htmlspecialchars($cliente->nombre) ?> | usuario: <?= htmlspecialchars($cliente->getUser()) ?></span>
                            <div>
                                <!-- Botones para editar y eliminar -->
                                <a href="formUpdateCliente.php?id=<?= $cliente->getNumero() ?>" class="btn btn-sm btn-outline-success me-2" style="width: 70px;">Editar</a>
                                <a href="removeCliente.php?id=<?= $cliente->getNumero() ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que quieres eliminar a este cliente?');">Eliminar</a>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay clientes registrados.</p>
        <?php endif; ?>

        <!-- Lista de soportes -->
        <h4>Listado de soportes</h4>
        <?php
        if (!empty($_SESSION['soportes'])) {
            echo '<ul class="list-group shadow-custom">';
            foreach ($_SESSION['soportes'] as $soporte) {
                echo '<li class="list-group-item bg-dark text-white">';
                echo $soporte['titulo'] . ' - ' . $soporte['precio'] . ' €';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No hay soportes disponibles.</p>';
        }
        ?>    

        <!-- Botones para añadir cliente y cerrar sesión -->
        <a href="formCreateCliente.php" class="btn btn-outline-primary mt-3 me-2">Añadir cliente</a>
        <a href="logout.php" class="btn btn-outline-danger mt-3">Cerrar sesión</a>
    </div>

    <!-- Script de JS para que los alert se vayan sólos y con efecto de desvanecerse -->
    <script>
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(a => {
            a.classList.add('fade-out');
            setTimeout(() => a.remove(), 600);
        });
    }, 2500);
    </script>
</body>
</html>
