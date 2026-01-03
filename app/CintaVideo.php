<?php
namespace Dwes\ProyectoVideoclub;

// Clase CintaVideo hija de Soporte
class CintaVideo extends Soporte {

    // Variable
    private $duracion;

    // Constructor
    public function __construct($titulo, $numero, $precio, $duracion) {
        parent::__construct($titulo, $numero, $precio);
        $this->duracion = $duracion;
    }

    // Método heredado de soporte en la cual es implementado por la interfaz Resumible
    public function muestraResumen() : void {
        echo "<strong>Película en VHS: </strong><br>";
        echo $this->titulo . " (Nº " . $this->getNumero() . ")<br>";
        echo $this->getPrecio() . " € (IVA no incluido)<br>";
        echo "Duración: " . $this->duracion . " minutos<br>" ;
    }
}
?>