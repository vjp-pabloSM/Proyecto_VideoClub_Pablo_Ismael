<?php
require_once __DIR__ . "/app/Cliente.php";
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;

session_start();

// Verificar que hay un cliente logueado
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
<body style="background-color:#282828; color:white;">
<div class="container my-5">

    <h2>Bienvenido, <?= htmlspecialchars($cliente->nombre) ?></h2>
    <a href="logout.php" class="btn btn-danger mb-4">Cerrar sesión</a>

    <h4>Listado de alquileres</h4>
    <ul class="list-group">
        <?php
        $alquileres = $cliente->getAlquileres();
        if (!empty($alquileres)) {
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

</div>
</body>
</html>
