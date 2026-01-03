<?php

require __DIR__ . '/../vendor/autoload.php';

use Dwes\ProyectoVideoclub\Videoclub;

$vc = new Videoclub("La Caverna de Platón");
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

$vc->incluirJuego("https://www.metacritic.com/game/god-of-war-ragnarok", "God of War", 19.99, "PS5", 1, 1);

$vc->incluirJuego("https://www.metacritic.com/game/the-last-of-us-part-ii", "The Last of Us Part II", 49.99, "PS4", 1, 1);

$vc->incluirDvd("https://www.metacritic.com/movie/torrente-the-dumb-arm-of-the-law", "Torrente", 4.5, "es", "16:9");

$vc->incluirDvd("https://www.metacritic.com/movie/interstellar", "Interstellar", 4.5, "es,en,fr", "16:9");

$vc->incluirDvd("https://www.metacritic.com/movie/star-wars-episode-v---the-empire-strikes-back", "El Imperio Contraataca", 3, "es,en", "16:9");

$vc->incluirCintaVideo("https://www.metacritic.com/movie/ghostbusters", "Los cazafantasmas", 3.5, 107);

$vc->incluirCintaVideo("https://www.metacritic.com/tv/the-name-of-the-rose", "El nombre de la Rosa", 1.5, 140);

// --- Listar productos ---
$vc->listarProductos();

// --- Crear socios ---
$vc->incluirSocio("Benito Martínez", 2);
$vc->incluirSocio("Emmanuel Gazmey");

// --- Encadenamiento de alquileres ---
$vc->alquilarSocioProducto(1, 2)
   ->alquilarSocioProducto(1, 4)
   ->alquilarSocioProducto(1, 2) // ya alquilado
   ->alquilarSocioProducto(1, 6); // supera el límite

// --- Listar socios ---
$vc->listarSocios();

echo "<h2>Puntuación Metacritic de los alquileres del cliente 1</h2>";

// Obtener cliente 1
$cliente = null;
foreach ($vc->getSocios() as $socio) {
   if ($socio->getNumero() === 1) {
      $cliente = $socio;
      break;
   }
}

if ($cliente) {
   $alquileres = $cliente->getAlquileres();

   if (empty($alquileres)) {
      echo "<p>El cliente no tiene alquileres.</p>";
   } else {
      echo "<ul>";
      foreach ($alquileres as $soporte) {
         $puntuacion = $soporte->getPuntuacion();

         echo "<li>";
         echo "<strong>{$soporte->titulo}</strong><br>";

         if ($puntuacion !== null) {
            echo "Puntuación Metacritic: <strong>{$puntuacion}</strong>";
         } else {
            echo "Puntuación Metacritic: no disponible";
         }
      echo "</li><br>";
      }
      echo "</ul>";
   }
}
?>

</body>
</html>

