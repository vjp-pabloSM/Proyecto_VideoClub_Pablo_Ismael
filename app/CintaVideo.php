<?php
namespace Dwes\ProyectoVideoclub;

/**
 * Clase CintaVideo
 *
 * Representa una cinta de vídeo en formato VHS dentro del videoclub.
 * Hereda de la clase Soporte e implementa el método de resumen
 * definido por la interfaz Resumible.
 *
 * @package Dwes\ProyectoVideoclub
 */
class CintaVideo extends Soporte {

    /**
     * Duración de la cinta en minutos
     *
     * @var int
     */
    private $duracion;

    /**
     * Constructor de la clase CintaVideo
     *
     * @param string $titulo      Título de la película
     * @param int    $numero      Número identificador del soporte
     * @param float  $precio      Precio del soporte (sin IVA)
     * @param string $metacritic  URL de Metacritic del soporte
     * @param int    $duracion    Duración de la película en minutos
     */
    public function __construct($titulo, $numero, $precio, string $metacritic, $duracion) {
        parent::__construct($titulo, $numero, $precio, $metacritic);
        $this->duracion = $duracion;
    }

    /**
     * @inheritDoc
     */
    public function getPuntuacion(): ?int {
        return $this->scrapMetacritic();
    }

    /**
     * Muestra un resumen con la información de la cinta de vídeo
     *
     * Implementa el método definido por la interfaz Resumible.
     * Muestra el título, número, precio y duración de la película.
     *
     * @return void
     */
    public function muestraResumen() : void {
        echo "<strong>Película en VHS: </strong><br>";
        echo $this->titulo . " (Nº " . $this->getNumero() . ")<br>";
        echo $this->getPrecio() . " € (IVA no incluido)<br>";
        echo "Duración: " . $this->duracion . " minutos<br>";
    }
}
?>