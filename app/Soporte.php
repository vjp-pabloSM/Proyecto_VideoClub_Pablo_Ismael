<?php

namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\interfaz\Resumible;

abstract class Soporte implements Resumible
{
    // Variables
    public string $titulo = "";
    public bool $alquilado = false;
    protected int $numero = 0;
    private float $precio = 0;
    private const IVA = 0.21;

    // Constructor
    public function __construct(string $titulo, int $numero, float $precio)
    {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    // Getters
    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function getPrecioConIva(): float
    {
        return round($this->precio * (1 + self::IVA), 2);
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    // Método abstracto implementado de la interfaz Resumible
    abstract public function muestraResumen(): void;
}
