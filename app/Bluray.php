<?php

namespace Dwes\ProyectoVideoclub;

/**
 * Clase Bluray
 *
 * Representa un soporte en formato Blu-ray dentro del videoclub.
 * Hereda de la clase Soporte e implementa el método de resumen
 * definido por la interfaz Resumible.
 *
 * Almacena además si es 4K.
 *
 * @package Dwes\ProyectoVideoclub
 */
class Bluray extends Soporte
{
    /**
     * Duración del Blu-ray en minutos
     *
     * @var int
     */
    private int $duracion;

    /**
     * Indica si el Bluray es 4K
     *
     * @var bool
     */
    private bool $es4k;

    /**
     * Constructor de la clase Bluray
     *
     * @param string $titulo      Título del Bluray
     * @param int    $numero      Número identificador del soporte
     * @param float  $precio      Precio del soporte
     * @param string $metacritic  URL de Metacritic
     * @param int    $duracion    Duración del contenido
     * @param bool   $es4k        Indica si es 4K
     */
    public function __construct($titulo, $numero, $precio, string $metacritic, int $duracion, bool $es4k)
    {
        parent::__construct($titulo, $numero, $precio, $metacritic);
        $this->duracion = $duracion;
        $this->es4k = $es4k;
    }

    /**
     * @inheritDoc
     */
    public function getPuntuacion(): ?int
    {
        return $this->scrapMetacritic();
    }

    /**
     * Devuelve si el Bluray es 4K
     *
     * @return bool
     */
    public function es4k(): bool
    {
        return $this->es4k;
    }

    /**
     * Muestra un resumen con la información del Bluray
     *
     * Implementa el método definido por la interfaz Resumible.
     * Muestra título, número, precio, duración y si es 4K.
     *
     * @return string
     */
    public function muestraResumen(): string
    {
        $formato4k = $this->es4k ? "4K" : "HD";
        $texto = "Película en Bluray: $this->titulo (Nº {$this->getNumero()}) - {$this->getPrecio()} € - Duración: {$this->duracion} min - $formato4k";
        echo $texto;
        return $texto;
    }
}
