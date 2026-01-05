<?php

namespace Dwes\ProyectoVideoclub\Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Juego;

class JuegoTest extends TestCase
{
    public function testCrearJuego()
    {
        $juego = new Juego(
            "FIFA 24",
            1,
            60,
            "https://www.metacritic.com",
            "PlayStation",
            1,
            4
        );

        $this->assertEquals("FIFA 24", $juego->titulo);
        $this->assertEquals(1, $juego->getNumero());
        $this->assertEquals(60, $juego->getPrecio());
    }

    public function testPrecioConIva()
    {
        $juego = new Juego(
            "Mario Kart",
            2,
            50,
            "https://www.metacritic.com",
            "Nintendo",
            1,
            2
        );

        $this->assertEquals(60.5, $juego->getPrecioConIva());
    }

    public function testMuestraResumenDevuelveTexto()
    {
        $juego = new Juego(
            "Zelda",
            3,
            70,
            "https://www.metacritic.com",
            "Switch",
            1,
            1
        );

        $resultado = $juego->muestraResumen(); // Debe devolver string

        $this->assertIsString($resultado);
        if (is_string($resultado)) {
            $this->assertStringContainsString("Zelda", $resultado);
        }
    }
}
