<?php
namespace Dwes\ProyectoVideoclub;


// Clase Juego hija de Soporte
class Juego extends Soporte {

    // Variables
    public $consola;
    private $minNumJugadores;
    private $maxNumJugadores;

    // Constructor
    public function __construct($titulo, $numero, $precio, $consola, $minNumJugadores, $maxNumJugadores) {
            parent::__construct($titulo, $numero, $precio);
            $this->consola = $consola;
            $this->minNumJugadores = $minNumJugadores;
            $this->maxNumJugadores = $maxNumJugadores;
    }

    // Muestra el número posible de jugadores
    public function muestraJugadoresPosibles() {
        if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1) {
            echo "Para un jugador<br>";
        } elseif ($this->minNumJugadores == $this->maxNumJugadores) {
            echo "Para $this->maxNumJugadores jugadores<br>";
        } else {
            echo "De ". $this->minNumJugadores." a ". $this->maxNumJugadores." jugadores<br>";
        }
    }

    // Método heredado de soporte en la cual es implementado por la interfaz Resumible
    public function muestraResumen() : void {
        echo "<strong>Juego para: " . $this->consola . "</strong><br>" ;
        echo $this->titulo . " (Nº " . $this->getNumero() . ")<br>";
        echo $this->getPrecio() . " € (IVA no incluido)<br>";
        $this->muestraJugadoresPosibles() ;
    }
}
?>