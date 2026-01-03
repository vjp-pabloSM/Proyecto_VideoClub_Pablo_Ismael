<?php
require __DIR__ . '/vendor/autoload.php';
session_start();

// Solo el admin puede crear clientes
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Validar campos enviados por POST
$nombre   = trim($_POST['nombre'] ?? '');
$user     = trim($_POST['user'] ?? '');
$password = trim($_POST['password'] ?? '');
$max      = 3;

if ($nombre === '' || $user === '' || $password === '') {
    $_SESSION['error'] = "Todos los campos son obligatorios";
    header("Location: formCreateCliente.php");
    exit();
}

// Asegurar que existe el array de clientes
if (!isset($_SESSION['clientes'])) {
    $_SESSION['clientes'] = [];
}

// Verificar que el nombre de usuario no exista (ARRAYS, no objetos)
foreach ($_SESSION['clientes'] as $c) {
    if ($c['user'] === $user) {
        $_SESSION['error'] = "El nombre de usuario '{$user}' ya existe. Elige otro.";
        header("Location: formCreateCliente.php");
        exit();
    }
}

// Calcular nuevo ID de cliente
$numeros = array_column($_SESSION['clientes'], 'numero');
$nuevoId = empty($numeros) ? 1 : max($numeros) + 1;

// Guardar el nuevo cliente (DATOS PLANOS)
$_SESSION['clientes'][] = [
    'nombre'   => $nombre,
    'numero'   => $nuevoId,
    'user'     => $user,
    'password' => $password,
    'max'      => $max
];

// Mensaje de confirmación
$_SESSION['mensaje'] = "Cliente '{$nombre}' creado correctamente con ID: {$nuevoId}";

// Volver al panel de administración
header("Location: mainAdmin.php");
exit();
