<?php
// Inicia la sesión
session_start();

// Cierra la sesión del usuario destruyendo lo que hayen ella
session_destroy();

// Redirige al usuario a la página de inicio
header("Location: index.php"); 
exit();
?>