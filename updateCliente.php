<?php
require_once __DIR__ . "/app/Cliente.php";
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;

session_start();

// Recoge el ID del cliente desde el formulario (POST), si no viene, será null
$id = $_POST['id'] ?? null;

// Recoge y limpia los campos del formulario usando trim() para eliminar espacios al inicio y final
$nombre = trim($_POST['nombre'] ?? '');
$user = trim($_POST['user'] ?? '');
$password = trim($_POST['password'] ?? '');

// Si no se pasó id, usamos el del cliente logueado
if ($id === null && isset($_SESSION['cliente_actual'])) {
    $id = $_SESSION['cliente_actual']->getNumero();
}

// Validaciones
if ($nombre === '' || $user === '' || $password === '') {
    $_SESSION['error'] = "Todos los campos son obligatorios.";
    header("Location: formUpdateCliente.php?id=$id");
    exit();
}

// Evita duplicados
foreach ($_SESSION['clientes'] as $c) {
    if (!$c instanceof Cliente) continue;
    if ($c->getNumero() != $id && ($c->nombre === $nombre || $c->getUser() === $user)) {
        $_SESSION['error'] = "Ya existe un cliente con ese nombre o usuario.";
        header("Location: formUpdateCliente.php?id=$id");
        exit();
    }
}

// Actualiza cliente
foreach ($_SESSION['clientes'] as $c) {
    if ($c instanceof Cliente && $c->getNumero() == $id) {
        $c->nombre = $nombre;
        $c->setUser($user);
        $c->setPassword($password);
        break;
    }
}

// Actualiza cliente de sesión si corresponde
if (isset($_SESSION['cliente_actual']) && $_SESSION['cliente_actual']->getNumero() == $id) {
    $_SESSION['cliente_actual']->nombre = $nombre;
    $_SESSION['cliente_actual']->setUser($user);
    $_SESSION['cliente_actual']->setPassword($password);
}

// Redirige según tipo de usuario
header("Location: " . ($_SESSION['user'] === 'admin' ? 'mainAdmin.php' : 'mainCliente.php'));
exit();
