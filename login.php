<?php
session_start();
require_once __DIR__ . "/app/Cliente.php";
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

// Array de clientes de prueba (siempre disponible)
$clientes = [
    new Cliente("Benito Martinez", 1, "Bad Bunny", "1234"),
    new Cliente("Enmanuel Gazmey", 2, "Anuel AA", "1111"),
    new Cliente("Samuel de Luque", 3, "Vegetta777", "1212"),
    new Cliente("Guillermo Diaz", 3, "Willyrex", "2222")
];
$_SESSION['clientes'] = $clientes;

// Array de soportes de prueba
$_SESSION['soportes'] = [
    ["titulo" => "God of War", "precio" => 19.99],
    ["titulo" => "Torrento", "precio" => 4.5],
    ["titulo" => "El Imperio Contrataca", "precio" => 3.0],
    ["titulo" => "EL nombre de la rosa", "precio" => 1.5]
];

// Admin
$adminUser = "admin";
$adminPass = "admin";

if ($usuario === $adminUser && $password === $adminPass) {
    $_SESSION['user'] = "admin";
    header("Location: mainAdmin.php");
    exit();
}

// Clientes
foreach ($clientes as $cliente) {
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
