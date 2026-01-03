<?php
require __DIR__ . '/../vendor/autoload.php';

use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Juego;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="IsmaelGJ">
    <title>Inicio - Pruebas Videoclub</title>
    <link rel="stylesheet" href="../css/estiloVideoclub.css">
</head>
<body>

<h1>Estás en Inicio (Pruebas de clases)</h1>

<?php
// Inicio Soporte (ahora usamos DVD porque Soporte es abstracta)
$soporte1 = new Dvd("Batman", 22, 17, "es,en", "16:9"); 
echo "<strong>{$soporte1->titulo}</strong><br>";
echo "Precio: {$soporte1->getPrecio()} €<br>";
echo "Precio IVA incluido: {$soporte1->getPrecioConIva()} €<br>";
$soporte1->muestraResumen();

echo "<hr>";

// Inicio CintaVideo
$miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107); 
echo "<strong>{$miCinta->titulo}</strong><br>";
echo "Precio: {$miCinta->getPrecio()} €<br>";
echo "Precio IVA incluido: {$miCinta->getPrecioConIva()} €<br>";
$miCinta->muestraResumen();

echo "<hr>";

// Inicio DVD
$miDvd = new Dvd("Origen", 24, 15, "es,en,fr", "16:9"); 
echo "<strong>{$miDvd->titulo}</strong><br>";
echo "Precio: {$miDvd->getPrecio()} €<br>";
echo "Precio IVA incluido: {$miDvd->getPrecioConIva()} €<br>";
$miDvd->muestraResumen();

echo "<hr>";

// Inicio Juego
$miJuego = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1); 
echo "<strong>{$miJuego->titulo}</strong><br>";
echo "Precio: {$miJuego->getPrecio()} €<br>";
echo "Precio IVA incluido: {$miJuego->getPrecioConIva()} €<br>";
$miJuego->muestraResumen();
?>

</body>
</html>
