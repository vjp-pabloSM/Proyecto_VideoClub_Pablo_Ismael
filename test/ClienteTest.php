<?php
namespace Dwes\ProyectoVideoclub\Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Juego;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;

class ClienteTest extends TestCase
{
    /** @dataProvider proveedorSoportes */
    public function testAlquilarSoportes($soporte)
    {
        $cliente = new Cliente("Pablo", 1);

        // Alquila el soporte
        $cliente->alquilar($soporte);
        $this->assertTrue($cliente->tieneAlquilado($soporte));
        $this->assertEquals(1, count($cliente->getSoportesAlquilados()));

        // Intentar alquilar otra vez el mismo soporte → excepción
        $this->expectException(SoporteYaAlquiladoException::class);
        $cliente->alquilar($soporte);
    }

    public function proveedorSoportes()
    {
        return [
            [new CintaVideo("Titanic", 1, 5, "https://metacritic.com", 120)],
            [new Dvd("Matrix", 2, 10, "https://metacritic.com", "Español, Inglés", "16:9")],
            [new Juego("FIFA", 3, 60, "https://metacritic.com", "PS5", 1, 4)]
        ];
    }

    public function testCupoMaximo()
    {
        $cliente = new Cliente("Ana", 2, '', '', 2); // max 2 alquileres
        $soporte1 = new CintaVideo("Star Wars", 4, 6, "https://metacritic.com", 130);
        $soporte2 = new Dvd("Avatar", 5, 8, "https://metacritic.com", "Español", "16:9");
        $soporte3 = new Juego("Zelda", 6, 50, "https://metacritic.com", "Switch", 1, 2);

        $cliente->alquilar($soporte1);
        $cliente->alquilar($soporte2);

        $this->expectException(CupoSuperadoException::class);
        $cliente->alquilar($soporte3);
    }

    public function testDevolverSoporte()
    {
        $cliente = new Cliente("Luis", 3);
        $soporte = new CintaVideo("Gladiator", 7, 7, "https://metacritic.com", 140);

        $cliente->alquilar($soporte);
        $this->assertTrue($cliente->tieneAlquilado($soporte));

        $cliente->devolver($soporte->getNumero());
        $this->assertFalse($cliente->tieneAlquilado($soporte));
        $this->assertEquals(0, count($cliente->getSoportesAlquilados()));
    }
}
?>
