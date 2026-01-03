<?php
require __DIR__ . '/vendor/autoload.php';
session_start();

// Recoger ID del cliente
$id = isset($_POST['id']) ? (int) $_POST['id'] : null;

// Recoger y limpiar campos
$nombre   = trim($_POST['nombre'] ?? '');
$user     = trim($_POST['user'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validación básica
if ($id === null || $nombre === '' || $user === '' || $password === '') {
    $_SESSION['error'] = "Todos los campos son obligatorios.";
    header("Location: formUpdateCliente.php?id={$id}");
    exit();
}

// Asegurar que hay clientes
if (empty($_SESSION['clientes'])) {
    $_SESSION['error'] = "No hay clientes disponibles.";
    header("Location: mainAdmin.php");
    exit();
}

// Evitar duplicados de usuario
foreach ($_SESSION['clientes'] as $c) {
    if ($c['numero'] != $id && $c['user'] === $user) {
        $_SESSION['error'] = "Ya existe un cliente con ese nombre de usuario.";
        header("Location: formUpdateCliente.php?id={$id}");
        exit();
    }
}

// Actualizar cliente
$clienteActualizado = false;

foreach ($_SESSION['clientes'] as &$c) {
    if ($c['numero'] == $id) {
        $c['nombre']   = $nombre;
        $c['user']     = $user;
        $c['password'] = $password;
        $clienteActualizado = true;
        break;
    }
}
unset($c);

// Actualizar cliente logueado si corresponde
if (
    isset($_SESSION['cliente_actual']) &&
    $_SESSION['cliente_actual']['numero'] == $id
) {
    $_SESSION['cliente_actual']['nombre']   = $nombre;
    $_SESSION['cliente_actual']['user']     = $user;
    $_SESSION['cliente_actual']['password'] = $password;
}

// Mensaje de confirmación
if ($clienteActualizado) {
    $_SESSION['mensaje'] = "Datos del cliente actualizados correctamente.";
} else {
    $_SESSION['error'] = "Cliente no encontrado.";
}

// Redirigir según tipo de usuario
header("Location: " . ($_SESSION['user'] === 'admin' ? 'mainAdmin.php' : 'mainCliente.php'));
exit();
