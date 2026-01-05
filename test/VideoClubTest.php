<?php
namespace Dwes\ProyectoVideoclub\Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Juego;
use Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException;

class VideoclubTest extends TestCase
{
    private Videoclub $videoclub;

    protected function setUp(): void
    {
        $this->videoclub = new Videoclub("MiVideoclub");

        // Añadimos socios
        $this->videoclub->incluirSocio("Pablo");
        $this->videoclub->incluirSocio("Ana");

        // Añadimos productos
        $this->videoclub->incluirCintaVideo("https://metacritic.com", "Titanic", 5, 120);
        $this->videoclub->incluirDvd("https://metacritic.com", "Matrix", 10, "Español", "16:9");
        $this->videoclub->incluirJuego("https://metacritic.com", "FIFA", 60, "PS5", 1, 4);
    }

    public function testAlquilarSocioProducto()
    {
        // Pablo = cliente nº1, Titanic = soporte nº1
        $this->videoclub->alquilarSocioProducto(1, 1);

        $socios = $this->videoclub->getSocios();
        $this->assertTrue($socios[0]->tieneAlquilado($socios[0]->getAlquileres()[0]));
    }

    public function testAlquilarSocioProductosMultiple()
    {
        // Añadimos método temporal en Videoclub que haga alquiler múltiple
        $this->videoclub->alquilarSocioProducto(1, 1);
        $this->videoclub->alquilarSocioProducto(1, 2);

        $socios = $this->videoclub->getSocios();
        $this->assertCount(2, $socios[0]->getAlquileres());
    }

    public function testDevolverSocioProducto()
    {
        $this->videoclub->alquilarSocioProducto(2, 2); // Ana alquila Matrix
        $socios = $this->videoclub->getSocios();
        $this->assertCount(1, $socios[1]->getAlquileres());

        $this->videoclub->devolverSocioProducto(2, 2); // Ana devuelve Matrix
        $this->assertCount(0, $socios[1]->getAlquileres());
    }

    public function testClienteNoExisteException()
    {
        $this->expectException(ClienteNoEncontradoException::class);

        // Intentamos alquilar con un cliente inexistente (id 99)
        $this->videoclub->alquilarSocioProducto(99, 1);
    }

    public function testDevolverClienteNoExisteException()
    {
        $this->expectException(ClienteNoEncontradoException::class);

        // Intentamos devolver con un cliente inexistente (id 99)
        $this->videoclub->devolverSocioProducto(99, 1);
    }
}
?>
