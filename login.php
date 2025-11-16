<?php
session_start();
require_once __DIR__ . "/app/Cliente.php";
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

// Clientes de prueba
if (!isset($_SESSION['clientes'])) {
    $_SESSION['clientes'] = [
        new Cliente("Benito Martinez", 1, "Bad Bunny", "1234", 3),
        new Cliente("Enmanuel Gazmey", 2, "Anuel AA", "1111", 3),
        new Cliente("Samuel de Luque", 3, "Vegetta777", "1212", 3),
        new Cliente("Guillermo Diaz", 4, "Willyrex", "2222", 3)
    ];
    error_log("Clientes iniciales creados por primera vez");
}

// Crear soportes de prueba
if (!isset($_SESSION['soportes'])) {
    $_SESSION['soportes'] = [
        ["titulo" => "God of War", "precio" => 19.99],
        ["titulo" => "Torrente", "precio" => 4.5],
        ["titulo" => "El Imperio Contrataca", "precio" => 3.0],
        ["titulo" => "EL nombre de la rosa", "precio" => 1.5]
    ];
}

// Admin: usuaro y contraseña
$adminUser = "admin";
$adminPass = "admin";

if ($usuario === $adminUser && $password === $adminPass) {
    $_SESSION['user'] = "admin";
    header("Location: mainAdmin.php");
    exit();
}

// Clientes
foreach ($_SESSION['clientes'] as $cliente) {
    if ($cliente instanceof Cliente && $cliente->getUser() === $usuario && $cliente->getPassword() === $password) {
        $_SESSION['user'] = $usuario;
        $_SESSION['cliente_actual'] = $cliente;
        header("Location: mainCliente.php");
        exit();
    }
}

// Usuario inválido
$_SESSION['error'] = "Usuario o contraseña incorrectos.";
header("Location: index.php");
exit();
?>
