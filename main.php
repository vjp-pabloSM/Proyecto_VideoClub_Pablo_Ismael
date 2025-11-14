<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];

if ($user === "admin") {
    header("Location: mainAdmin.php");
    exit();
}

// Para usuarios normales
echo "<h2>Bienvenido, $user</h2>";
echo '<a href="logout.php" class="btn btn-danger">Cerrar sesión</a>';
?>