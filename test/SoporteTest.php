<?php

namespace Dwes\ProyectoVideoclub\Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Soporte;

class SoporteTest extends TestCase
{
    /**
     * Crea un soporte mock para probar métodos concretos.
     */
    private function crearSoporteMock(): Soporte
    {
        return new class("TituloPrueba", 1, 10.0, "https://metacritic.com") extends Soporte {
            public function getPuntuacion(): ?int {
                return 80;
            }

            public function muestraResumen(): string {
                return "Resumen de prueba";
            }
        };
    }

    public function testGetPrecio()
    {
        $soporte = $this->crearSoporteMock();
        $this->assertEquals(10.0, $soporte->getPrecio());
    }

    public function testGetPrecioConIva()
    {
        $soporte = $this->crearSoporteMock();
        $this->assertEquals(12.1, $soporte->getPrecioConIva());
    }

    public function testGetNumero()
    {
        $soporte = $this->crearSoporteMock();
        $this->assertEquals(1, $soporte->getNumero());
    }

    public function testMuestraResumen()
    {
        $soporte = $this->crearSoporteMock();
        $resultado = $soporte->muestraResumen();
        $this->assertIsString($resultado);
        $this->assertStringContainsString("Resumen", (string)$resultado);
    }

    public function testGetPuntuacion()
    {
        $soporte = $this->crearSoporteMock();
        $this->assertEquals(80, $soporte->getPuntuacion());
    }
}
