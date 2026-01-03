<?php
require __DIR__ . '/vendor/autoload.php';
session_start();
$_SESSION = [];
session_destroy();

// Eliminar cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sesión limpiada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white d-flex justify-content-center align-items-center" style="height:100vh">
    <div class="text-center">
        <h3>Sesión limpiada completamente</h3>
        <p>Todos los clientes y datos han sido eliminados.</p>
        <a href="index.php" class="btn btn-primary">Volver a Login</a>
    </div>
</body>
</html>
