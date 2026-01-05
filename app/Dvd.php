<?php

namespace Dwes\ProyectoVideoclub;

/**
 * Clase Dvd
 *
 * Representa un soporte en formato DVD dentro del videoclub.
 * Hereda de la clase Soporte e implementa el método de resumen
 * definido por la interfaz Resumible.
 *
 * @package Dwes\ProyectoVideoclub
 */
class Dvd extends Soporte
{

    /**
     * Idiomas disponibles en el DVD
     *
     * @var string
     */
    public $idiomas;

    /**
     * Formato de pantalla del DVD
     *
     * @var string
     */
    private $formatPantalla;

    /**
     * Duración de la película en minutos
     *
     * @var int
     */
    private $duracion;

    /**
     * Constructor de la clase Dvd
     *
     * @param string $titulo          Título de la película
     * @param int    $numero          Número identificador del soporte
     * @param float  $precio          Precio del soporte (sin IVA)
     * @param string $metacritic      URL de Metacritic del soporte
     * @param string $idiomas         Idiomas disponibles
     * @param string $formatPantalla  Formato de pantalla (4:3, 16:9, etc.)
     * @param int    $duracion        Duración de la película en minutos
     */
    public function __construct($titulo, $numero, $precio, string $metacritic, $idiomas, $formatPantalla, int $duracion = 0)
    {
        parent::__construct($titulo, $numero, $precio, $metacritic);
        $this->idiomas = $idiomas;
        $this->formatPantalla = $formatPantalla;
        $this->duracion = $duracion;
    }

    /**
     * @inheritDoc
     */
    public function getPuntuacion(): ?int
    {
        return $this->scrapMetacritic();
    }

    /**
     * Muestra un resumen con la información del DVD
     *
     * Implementa el método definido por la interfaz Resumible.
     * Muestra el título, número, precio, idiomas, formato de pantalla y duración.
     *
     * @return string
     */
    public function muestraResumen(): string
    {
        $texto = "Película en DVD: $this->titulo (Nº {$this->getNumero()}) - {$this->getPrecio()} € - Idiomas: $this->idiomas - Formato: {$this->formatPantalla} - Duración: {$this->duracion} min.";
        echo $texto;
        return $texto;
    }
}
