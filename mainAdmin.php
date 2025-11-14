<?php
// INCLUIR la clase ANTES de session_start
require_once __DIR__ . "/app/Cliente.php";
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;

session_start(); // DESPUÉS de incluir la clase

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
<body style="background-color:#282828; color:white;">
<div class="container my-5">
    <h2 class="mb-4">Bienvenido Administrador</h2>
    
    
    <h4>Listado de clientes</h4>
    <?php
    if (!empty($_SESSION['clientes'])) {
        echo '<ul class="list-group mb-4">';
        foreach ($_SESSION['clientes'] as $cliente) {
            // COMPROBAMOS que sea objeto Cliente
            if ($cliente instanceof Cliente) {
                echo '<li class="list-group-item bg-dark text-white">';
                echo $cliente->nombre . ' | usuario: ' . $cliente->getUser();
                echo '</li>';
            }
        }
        
        echo '</ul>';
    } else {
        echo '<p>No hay clientes registrados.</p>';
    }
    ?>

    <h4>Listado de soportes</h4>
    <?php
    if (!empty($_SESSION['soportes'])) {
        echo '<ul class="list-group">';
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
    <a href="formCreateCliente.php" class="btn btn-outline-primary mt-3">Añadir cliente</a>
    <a href="logout.php" class="btn btn-outline-danger mt-3">Cerrar sesión</a>
</div>
</body>
</html>