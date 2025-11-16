<?php
require_once __DIR__ . "/app/Cliente.php";
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;

session_start();

// Solo el admin puede crear clientes
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Validar campos enviados por POST
$nombre   = $_POST['nombre'] ?? '';
$user     = $_POST['user'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($nombre) || empty($user) || empty($password)) {
    $_SESSION['error'] = "Todos los campos son obligatorios";
    header("Location: formCreateCliente.php");
    exit();
}

// Verificar que el usuario no exista
foreach ($_SESSION['clientes'] as $c) {
    if ($c instanceof Cliente && $c->getUser() === $user) {
        $_SESSION['error'] = "El nombre de usuario '{$user}' ya existe. Elige otro.";
        header("Location: formCreateCliente.php");
        exit();
    }
}

// Asegurarse de que la sesión tenga clientes
if (!isset($_SESSION['clientes'])) {
    $_SESSION['error'] = "No hay clientes inicializados. Debes iniciar sesión primero.";
    header("Location: index.php");
    exit();
}

// Inicializar el contador de ID si no existe
if (!isset($_SESSION['ultimoId'])) {
    $idsExistentes = [];
    foreach ($_SESSION['clientes'] as $c) {
        if ($c instanceof Cliente) {
            $idsExistentes[] = $c->getNumero();
        }
    }
    $_SESSION['ultimoId'] = !empty($idsExistentes) ? max($idsExistentes) : 0;
}

// Calcula el nuevo ID
$nuevoId = $_SESSION['ultimoId'] + 1;
$_SESSION['ultimoId'] = $nuevoId;

// Crea el nuevo cliente
$nuevoCliente = new Cliente($nombre, $nuevoId, $user, $password, 3);

// Agrega a la sesión
$_SESSION['clientes'][] = $nuevoCliente;
$_SESSION['mensaje'] = "Cliente '{$nombre}' creado correctamente con ID: {$nuevoId}";

// Redirige a admin
header("Location: mainAdmin.php");
exit();
?>
