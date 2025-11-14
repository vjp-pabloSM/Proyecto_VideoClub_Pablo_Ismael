<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Crear Cliente - Videoclub</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container my-5">
        <h2 class="text-center">Crear Nuevo Cliente</h2>
        <?php
        if (!empty($_SESSION['error'])) {
            echo '<p class="text-danger">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <div class="d-flex justify-content-center align-items-center">
            <form action="createCliente.php" method="post" class="w-25 align-item-center">
                <div class="mb-3">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Usuario:</label>
                    <input type="text" name="user" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Contraseña:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <a href="mainAdmin.php" class="btn btn-outline-primary">Crear Cliente</a>
                <a href="mainAdmin.php" class="btn btn-outline-secondary">Volver</a>
            </form>
        </div>
    </div>
</body>
</html>
