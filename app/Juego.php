<?php

namespace Dwes\ProyectoVideoclub;

/**
 * Clase Juego
 *
 * Representa un videojuego disponible en el videoclub.
 * Hereda de la clase Soporte e implementa el método de resumen
 * definido por la interfaz Resumible.
 *
 * @package Dwes\ProyectoVideoclub
 */
class Juego extends Soporte
{

    /**
     * Consola para la que está disponible el juego
     *
     * @var string
     */
    public $consola;

    /**
     * Número mínimo de jugadores
     *
     * @var int
     */
    private $minNumJugadores;

    /**
     * Número máximo de jugadores
     *
     * @var int
     */
    private $maxNumJugadores;

    /**
     * Constructor de la clase Juego
     *
     * @param string $titulo           Título del juego
     * @param int    $numero           Número identificador del soporte
     * @param float  $precio           Precio del soporte (sin IVA)
     * @param string $metacritic       URL de Metacritic del soporte
     * @param string $consola          Consola del videojuego
     * @param int    $minNumJugadores  Número mínimo de jugadores
     * @param int    $maxNumJugadores  Número máximo de jugadores
     */
    public function __construct($titulo, $numero, $precio, string $metacritic, $consola, $minNumJugadores, $maxNumJugadores)
    {
        parent::__construct($titulo, $numero, $precio, $metacritic);
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

    /**
     * Muestra el número posible de jugadores del juego
     *
     * Indica si el juego es para un solo jugador,
     * para un número fijo o para un rango de jugadores.
     *
     * @return void
     */
    public function muestraJugadoresPosibles()
    {
        if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1) {
            echo "Para un jugador<br>";
        } elseif ($this->minNumJugadores == $this->maxNumJugadores) {
            echo "Para $this->maxNumJugadores jugadores<br>";
        } else {
            echo "De " . $this->minNumJugadores . " a " . $this->maxNumJugadores . " jugadores<br>";
        }
    }

    /**
     * @inheritDoc
     */
    public function getPuntuacion(): ?int
    {
        return $this->scrapMetacritic();
    }

    /**
     * Muestra un resumen con la información del juego
     *
     * Implementa el método definido por la interfaz Resumible.
     * Muestra la consola, título, número, precio y número de jugadores.
     *
     * @return void
     */
    public function muestraResumen(): string
    {
        $jugadores = ($this->minNumJugadores == $this->maxNumJugadores)
            ? $this->maxNumJugadores . " jugador(es)"
            : "De {$this->minNumJugadores} a {$this->maxNumJugadores} jugadores";

        $texto = "Juego para {$this->consola}: $this->titulo (Nº {$this->getNumero()}) - {$this->getPrecio()} € - $jugadores";
        echo $texto;
        return $texto;
    }
}
