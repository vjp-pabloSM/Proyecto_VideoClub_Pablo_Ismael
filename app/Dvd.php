<?php
namespace Dwes\ProyectoVideoclub;


// Clase Dvd hija de Soporte
class Dvd extends Soporte {

    // Variables
    public $idiomas;
    private $formatPantalla;

    // Constructor
    public function __construct($titulo, $numero, $precio, $idiomas, $formatPantalla) {
        parent::__construct($titulo, $numero, $precio);
        $this->idiomas = $idiomas;
        $this->formatPantalla = $formatPantalla;
    }

    // Método heredado de soporte en la cual es implementado por la interfaz Resumible
    public function muestraResumen() : void {
        echo "<strong>Película en DVD: </strong><br>";
        echo $this->titulo . " (Nº " . $this->getNumero() . ")<br>";
        echo $this->getPrecio() . " € (IVA no incluido)<br>";
        echo "Idiomas: " . $this->idiomas . "<br>" ;
        echo "Formato de pantalla: " . $this->formatPantalla . "<br>" ;
    }

}
?>