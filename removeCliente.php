<?php
require __DIR__ . '/vendor/autoload.php';
session_start();

// Solo el admin puede eliminar clientes
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Obtener ID del cliente
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

if ($id === null) {
    $_SESSION['error'] = "ID de cliente inválido";
    header("Location: mainAdmin.php");
    exit();
}

// Verificar que hay clientes
if (empty($_SESSION['clientes'])) {
    $_SESSION['error'] = "No hay clientes para eliminar";
    header("Location: mainAdmin.php");
    exit();
}

// Eliminar cliente por ID
$clientesNuevos = [];
$clienteEncontrado = false;

foreach ($_SESSION['clientes'] as $cliente) {
    if ($cliente['numero'] == $id) {
        $clienteEncontrado = true;
        continue;
    }
    $clientesNuevos[] = $cliente;
}

// Guardar resultado
if ($clienteEncontrado) {
    $_SESSION['clientes'] = $clientesNuevos;
    $_SESSION['mensaje'] = "Cliente eliminado correctamente";
} else {
    $_SESSION['error'] = "Cliente no encontrado";
}

// Volver al panel de administración
header("Location: mainAdmin.php");
exit();
