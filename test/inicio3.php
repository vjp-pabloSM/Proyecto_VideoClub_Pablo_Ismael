<?php

require __DIR__ . '/../vendor/autoload.php';
use Dwes\ProyectoVideoclub\Videoclub;

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="author" content="IsmaelGJ">
   <title>Inicio 3 - Pruebas Videoclub</title>
   <link rel="stylesheet" href="../css/estiloVideoclub.css">
</head>
<body>

<h1>Estás en Inicio 3 (Pruebas Videoclub)</h1>

<?php
$vc = new Videoclub("La Caverna de Platón"); 

// --- Incluir soportes de prueba ---
$vc->incluirJuego("God of War", 19.99, "PS5", 1, 1); 
$vc->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1);
$vc->incluirDvd("Torrente", 4.5, "es", "16:9"); 
$vc->incluirDvd("Interstellar", 4.5, "es,en,fr", "16:9"); 
$vc->incluirDvd("El Imperio Contraataca", 3, "es,en", "16:9"); 
$vc->incluirCintaVideo("Los cazafantasmas", 3.5, 107); 
$vc->incluirCintaVideo("El nombre de la Rosa", 1.5, 140); 

// --- Listar productos ---
$vc->listarProductos(); 

// --- Crear socios ---
$vc->incluirSocio("Benito Martínez", 2); 
$vc->incluirSocio("Emmanuel Gazmey"); 

// --- Encadenamiento de alquileres ---
$vc->alquilarSocioProducto(1, 2)
   ->alquilarSocioProducto(1, 3)
   // intento alquilar de nuevo el soporte 2 (ya alquilado)
   ->alquilarSocioProducto(1, 2)
   // intento alquilar el soporte 6 (supera el límite)
   ->alquilarSocioProducto(1, 6);

// --- Listar socios ---
$vc->listarSocios();
?>

</body>
</html>
