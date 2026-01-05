<?php

namespace Dwes\ProyectoVideoclub\Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Dvd;

class DvdTest extends TestCase
{
    public function testCrearDvd()
    {
        $dvd = new Dvd(
            "Inception",
            1,
            5.5,
            "https://www.metacritic.com",
            "Español, Inglés",
            "16:9"
        );

        $this->assertEquals("Inception", $dvd->titulo);
        $this->assertEquals(1, $dvd->getNumero());
        $this->assertEquals(5.5, $dvd->getPrecio());
    }

    public function testPrecioConIva()
    {
        $dvd = new Dvd(
            "Avatar",
            2,
            8,
            "https://www.metacritic.com",
            "Español, Inglés",
            "16:9"
        );

        $this->assertEquals(9.68, $dvd->getPrecioConIva());
    }

    public function testMuestraResumenDevuelveTexto()
    {
        $dvd = new Dvd(
            "Titanic",
            3,
            6,
            "https://www.metacritic.com",
            "Español, Inglés",
            "4:3"
        );

        // Modificación: vamos a devolver un string en lugar de solo echo
        $texto = "Película en DVD: Titanic (Nº 3) - 6 € - Idiomas: Español, Inglés - Formato: 4:3";
        $resultado = $dvd->muestraResumen();

        $this->assertIsString($resultado);
        $this->assertStringContainsString("Titanic", $resultado);
    }
}
