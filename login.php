<?php
require __DIR__ . '/vendor/autoload.php';
session_start();

$usuario  = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

// Clientes de prueba
if (!isset($_SESSION['clientes'])) {
    $_SESSION['clientes'] = [
        [
            'nombre' => 'Benito Martinez',
            'numero' => 1,
            'user' => 'Bad Bunny',
            'password' => '1234',
            'max' => 3
        ],
        [
            'nombre' => 'Enmanuel Gazmey',
            'numero' => 2,
            'user' => 'Anuel AA',
            'password' => '1111',
            'max' => 3
        ],
        [
            'nombre' => 'Samuel de Luque',
            'numero' => 3,
            'user' => 'Vegetta777',
            'password' => '1212',
            'max' => 3
        ],
        [
            'nombre' => 'Guillermo Diaz',
            'numero' => 4,
            'user' => 'Willyrex',
            'password' => '2222',
            'max' => 3
        ]
    ];
}

// Soportes de prueba
if (!isset($_SESSION['soportes'])) {
    $_SESSION['soportes'] = [
        ['titulo' => 'God of War', 'precio' => 19.99],
        ['titulo' => 'Torrente', 'precio' => 4.5],
        ['titulo' => 'El Imperio Contraataca', 'precio' => 3.0],
        ['titulo' => 'El nombre de la rosa', 'precio' => 1.5]
    ];
}

// Login admin
if ($usuario === 'admin' && $password === 'admin') {
    $_SESSION['user'] = 'admin';
    header('Location: mainAdmin.php');
    exit();
}

// Login clientes
foreach ($_SESSION['clientes'] as $cliente) {
    if ($cliente['user'] === $usuario && $cliente['password'] === $password) {

        // Guardamos SOLO los datos necesarios
        $_SESSION['user'] = $usuario;
        $_SESSION['cliente_actual'] = [
            'nombre' => $cliente['nombre'],
            'numero' => $cliente['numero'],
            'user'   => $cliente['user'],
            'max'    => $cliente['max']
        ];

        header('Location: mainCliente.php');
        exit();
    }
}

// Usuario inválido
$_SESSION['error'] = 'Usuario o contraseña incorrectos.';
header('Location: index.php');
exit();
?>