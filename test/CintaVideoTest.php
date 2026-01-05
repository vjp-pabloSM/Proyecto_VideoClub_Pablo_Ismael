<?php

namespace Dwes\ProyectoVideoclub\Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\CintaVideo;

class CintaVideoTest extends TestCase
{
    public function testCrearCintaVideo()
    {
        $cinta = new CintaVideo(
            "Terminator",
            1,
            3.5,
            "https://www.metacritic.com",
            120
        );

        $this->assertEquals("Terminator", $cinta->titulo);
        $this->assertEquals(1, $cinta->getNumero());
        $this->assertEquals(3.5, $cinta->getPrecio());
        $this->assertFalse($cinta->alquilado);
    }

    public function testPrecioConIva()
    {
        $cinta = new CintaVideo(
            "Matrix",
            2,
            10,
            "https://www.metacritic.com",
            130
        );

        $this->assertEquals(12.1, $cinta->getPrecioConIva());
    }

    public function testMuestraResumenDevuelveTexto()
    {
        $cinta = new CintaVideo(
            "Alien",
            3,
            4,
            "https://www.metacritic.com",
            110
        );

        $resultado = $cinta->muestraResumen(); // debe devolver string

        $this->assertIsString($resultado);
        $this->assertStringContainsString("Alien", $resultado);
    }
}
