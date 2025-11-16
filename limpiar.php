<?php
session_start();

// Destruir completamente la sesión
session_destroy();

echo "<h3>Sesión limpiada completamente</h3>";
echo "<p>Todos los clientes y datos han sido eliminados.</p>";
echo "<a href='index.php' class='btn btn-primary'>Volver a Login</a>";

// Opcional: recrear la sesión vacía
session_start();
$_SESSION = [];
?>