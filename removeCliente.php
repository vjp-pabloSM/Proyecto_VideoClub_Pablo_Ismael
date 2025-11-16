<?php
require_once __DIR__ . "/app/Cliente.php";
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Cliente;

session_start();

// Solo admin puede eliminar clientes
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Obtener ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($id === null) {
    $_SESSION['error'] = "ID inválido";
    header("Location: mainAdmin.php");
    exit();
}

// Verificar que hay clientes
if (empty($_SESSION['clientes'])) {
    $_SESSION['error'] = "No hay clientes para eliminar";
    header("Location: mainAdmin.php");
    exit();
}

// Filtra los clientes para eliminar solo el que tenga el ID indicado
$clientesNuevos = [];
$clienteEncontrado = false;

foreach ($_SESSION['clientes'] as $cliente) {
    // Obtener el ID incluso si es __PHP_Incomplete_Class
    $numero = null;
    
    if ($cliente instanceof Cliente) {
        $numero = $cliente->getNumero();
    } elseif (is_object($cliente) && property_exists($cliente, 'numero')) {
        $numero = $cliente->numero;
    }
    
    if ($numero == $id) {
        $clienteEncontrado = true;
    } else {
        $clientesNuevos[] = $cliente;
    }
}

// Guarda cambios o mostra error
if ($clienteEncontrado) {
    $_SESSION['clientes'] = $clientesNuevos;
    $_SESSION['mensaje'] = "Cliente eliminado correctamente";
} else {
    $_SESSION['error'] = "Cliente no encontrado";
}

// Redirige al panel
header("Location: mainAdmin.php");
exit();
?>
