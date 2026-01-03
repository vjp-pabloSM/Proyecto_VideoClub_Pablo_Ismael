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
class Dvd extends Soporte {

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
     * Constructor de la clase Dvd
     *
     * @param string $titulo          Título de la película
     * @param int    $numero          Número identificador del soporte
     * @param float  $precio          Precio del soporte (sin IVA)
     * @param string $metacritic      URL de Metacritic del soporte
     * @param string $idiomas         Idiomas disponibles
     * @param string $formatPantalla  Formato de pantalla (4:3, 16:9, etc.)
     */
    public function __construct($titulo, $numero, $precio, string $metacritic, $idiomas, $formatPantalla) {
        parent::__construct($titulo, $numero, $precio, $metacritic);
        $this->idiomas = $idiomas;
        $this->formatPantalla = $formatPantalla;
    }

    /**
     * @inheritDoc
     */
    public function getPuntuacion(): ?int {
        return $this->scrapMetacritic();
    }    

    /**
     * Muestra un resumen con la información del DVD
     *
     * Implementa el método definido por la interfaz Resumible.
     * Muestra el título, número, precio, idiomas y formato de pantalla.
     *
     * @return void
     */
    public function muestraResumen() : void {
        echo "<strong>Película en DVD: </strong><br>";
        echo $this->titulo . " (Nº " . $this->getNumero() . ")<br>";
        echo $this->getPrecio() . " € (IVA no incluido)<br>";
        echo "Idiomas: " . $this->idiomas . "<br>";
        echo "Formato de pantalla: " . $this->formatPantalla . "<br>";
    }
}
?>