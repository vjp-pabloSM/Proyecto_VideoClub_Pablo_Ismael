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
   <title>Inicio 2 - Pruebas Videoclub</title>
   <link rel="stylesheet" href="../css/estiloVideoclub.css">
</head>
<body>

<h1>Estás en Inicio 2 (Pruebas Videoclub)</h1>

<?php
// --- Crear videoclub y añadir soportes ---
$vc = new Videoclub('La Caverna de Platón');

$vc->incluirCintaVideo("Los cazafantasmas", 3.5, 107);
$vc->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1);
$vc->incluirDvd("Origen", 15, "es,en,fr", "16:9");
$vc->incluirDvd("El Imperio Contraataca", 3, "es,en", "16:9");

// --- Crear socios ---
$vc->incluirSocio("Samuel de Luque", 3);   // socio nº1
$vc->incluirSocio("Guillermo Díaz", 3);    // socio nº2

// --- Alquileres con socio 1 ---
$vc->alquilarSocioProducto(1, 1)   // Samuel alquila Los cazafantasmas
   ->alquilarSocioProducto(1, 2)   // Samuel alquila The Last of Us
   ->alquilarSocioProducto(1, 3);  // Samuel alquila Origen

// Intento alquilar de nuevo un soporte ya alquilado
$vc->alquilarSocioProducto(1, 1);  // debería avisar que ya lo tiene

// Intento alquilar un soporte que supera el límite
$vc->alquilarSocioProducto(1, 4);  // máximo 3 soportes

// Devoluciones
$vc->devolverSocioProducto(1, 4);  // intenta devolver algo no alquilado
$vc->devolverSocioProducto(1, 2);  // devuelve The Last of Us
$vc->alquilarSocioProducto(1, 4);  // ahora puede alquilar El Imperio Contraataca

// Listar alquileres actuales de socios
$vc->listarSocios();
$vc->listarProductos();

// --- Pruebas con socio 2 (no tiene alquileres aún) ---
$vc->devolverSocioProducto(2, 2);  // intenta devolver algo que no tiene
?>

</body>
</html>
