<?php
require_once __DIR__ . "/app/Cliente.php";
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;

session_start();

// Verifica que hay un cliente logueado
if (!isset($_SESSION['cliente_actual'])) {
    header("Location: index.php");
    exit();
}

$cliente = $_SESSION['cliente_actual'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Cliente - Videoclub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .shadow-custom {
        box-shadow: 0px 0px 20px rgba(0, 0, 255, 0.15);
    }
</style>
<body class="bg-dark text-white">

    <!-- Contenedor principal -->
    <div class="container my-5 w-50">
        <h2 class="mb-4 text-center">Bienvenido, <?= htmlspecialchars($cliente->nombre) ?></h2>

        <!-- Listado de alquileres del cliente -->
        <h4>Listado de alquileres</h4>
        <ul class="list-group mb-4 shadow-custom">
            <?php
            // Obtener los alquileres del cliente
            $alquileres = $cliente->getAlquileres();

            if (!empty($alquileres)) {

                // Mostra soportes para alquilar en una lista
                foreach ($alquileres as $soporte) {
                    echo '<li class="list-group-item bg-dark text-white">';
                    $soporte->muestraResumen();
                    echo '</li>';
                }
            } else {
                echo '<li class="list-group-item bg-dark text-white">No hay alquileres actualmente.</li>';
            }
            ?>
        </ul>

        <!-- Botones -->
        <div class="d-flex w-50">
            <a href="formUpdateCliente.php" class="btn btn-outline-success w-50 me-2">Editar mis datos</a>
            <a href="logout.php" class="btn btn-outline-danger w-50">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>
