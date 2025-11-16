<?php
session_start();

// Si no hay usuario logueado redirige al login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Obtener el usuario logueado desde la sesión
$user = $_SESSION['user'];

// Si el usuario es admin, redirige al panel de administrador
if ($user === "admin") {
    header("Location: mainAdmin.php");
    exit();
}

// Para usuarios normales mostra bienvenida
echo "<h2>Bienvenido, $user</h2>";

// Botón para cerrar sesión
echo '<a href="logout.php" class="btn btn-danger">Cerrar sesión</a>';
?>