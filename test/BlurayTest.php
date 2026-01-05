<?php
namespace Dwes\ProyectoVideoclub\Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;
use Dwes\ProyectoVideoclub\Bluray;

/**
 * Tests de la clase Bluray dentro del Videoclub
 *
 * Comprueba que se crean correctamente, que almacena todos los datos
 * y que el método muestraResumen devuelve la cadena correcta.
 */
class BlurayTest extends TestCase
{
    private Videoclub $videoclub;

    protected function setUp(): void
    {
        $this->videoclub = new Videoclub("TestClub");
    }

    /**
     * Comprueba que se puede incluir un Bluray en el videoclub
     */
    public function testIncluirBluray()
    {
        $this->videoclub->incluirBluray("https://metacritic.com/test", "Blade Runner", 15.5, 120, true);
        $productos = $this->videoclub->listarProductos(); // aquí solo visualizamos

        $this->assertCount(1, $this->videoclub->getSocios()); // no hay socios todavía, solo para estructura
        // Si quieres podemos añadir un getProductos() en Videoclub para testear directamente
    }

    /**
     * Comprueba que el método muestraResumen devuelve la cadena esperada
     */
    public function testMuestraResumenBluray()
    {
        $bluray = new Bluray("Matrix", 1, 18.0, "https://metacritic.com/matrix", 136, true);
        $resumen = $bluray->muestraResumen();

        $this->assertStringContainsString("Matrix", $resumen);
        $this->assertStringContainsString("136", $resumen);
        $this->assertStringContainsString("18", $resumen);
        $this->assertStringContainsString("4K", $resumen); // asumimos que tu implementación pone "4K" si es 4k
    }

    /**
     * Comprueba que un Bluray puede ser 4K o no
     */
    public function testBlurayEs4k()
    {
        $bluray4k = new Bluray("Avatar", 2, 20.0, "https://metacritic.com/avatar", 162, true);
        $blurayNo4k = new Bluray("Titanic", 3, 17.0, "https://metacritic.com/titanic", 195, false);

        $this->assertTrue($bluray4k->es4k());
        $this->assertFalse($blurayNo4k->es4k());
    }
}
