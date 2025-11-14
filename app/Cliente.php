<?php
namespace PROYECTO_VIDEOCLUB_PABLO_ISMAEL;

use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Util\SoporteYaAlquiladoException;
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Util\CupoSuperadoException;
use PROYECTO_VIDEOCLUB_PABLO_ISMAEL\Util\SoporteNoEncontradoException;

class Cliente {

    public $nombre = "";
    private $numero = 0;
    private $soportesAlquilados = [];
    private $numSoportesAlquilados = 0;
    private $maxAlquilerConcurrente;
    private $user = "";
    private $password = "";

    public function __construct($nombre, $numero, $user, $password, $maxAlquilerConcurrente = 3) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->user = $user;
        $this->password = $password;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
        $this->soportesAlquilados = [];
    }

    public function getUser() { 
        return $this->user; 
    }
    public function getPassword() { 
        return $this->password; 
    }
    public function getNumero() { 
        return $this->numero; 
    }
    public function setNumero($numero) { 
        $this->numero = $numero; 
    }
    public function getSoportesAlquilados() { 
        return $this->soportesAlquilados; 
    }
    public function getAlquileres(): array { 
        return $this->soportesAlquilados; 
    }

    // --- Métodos originales de alquiler, devolver, listarAlquileres, muestraResumen ---
    public function tieneAlquilado(Soporte $s): bool {
        foreach ($this->soportesAlquilados as $soporte) {
            if ($soporte->getNumero() === $s->getNumero()) return true;
        }
        return false;
    }

    public function alquilar(Soporte $s) {
        if ($this->tieneAlquilado($s)) {
            throw new SoporteYaAlquiladoException("El cliente {$this->nombre} (nº {$this->numero}) ya tiene alquilado el soporte nº {$s->getNumero()}.");
        }
        if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            throw new CupoSuperadoException("El cliente {$this->nombre} (nº {$this->numero}) ha alcanzado el máximo de alquileres ({$this->maxAlquilerConcurrente}).");
        }
        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++;
        $s->alquilado = true;

        echo "<p>El cliente {$this->nombre} ha alquilado este soporte: </p>";
        $s->muestraResumen();
        return $this;
    }

    public function devolver(int $numSoporte) {
        foreach ($this->soportesAlquilados as $indice => $soporte) {
            if ($soporte->getNumero() == $numSoporte) {
                unset($this->soportesAlquilados[$indice]);
                $this->soportesAlquilados = array_values($this->soportesAlquilados);
                $soporte->alquilado = false;
                echo "<p>El cliente {$this->nombre} ha devuelto el soporte nº {$numSoporte}.</p>";
                return $this;
            }
        }
        throw new SoporteNoEncontradoException("El cliente {$this->nombre} (nº {$this->numero}) no tenía alquilado el soporte nº {$numSoporte}.");
    }

    public function listarAlquileres(): void {
        $cantidad = count($this->soportesAlquilados);
        echo "<p>El cliente {$this->nombre} tiene actualmente {$cantidad} soporte(s) alquilado(s).</p>";
        if ($cantidad > 0) {
            echo "<ul>";
            foreach ($this->soportesAlquilados as $soporte) {
                echo "<li>";
                $soporte->muestraResumen();
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No hay soportes alquilados actualmente.</p>";
        }
    }

    public function muestraResumen() {
        echo "<p>Cliente: {$this->nombre}<br>Nº cliente: {$this->numero}<br>Soportes alquilados: " . count($this->soportesAlquilados) . " de {$this->maxAlquilerConcurrente} posibles.</p>";
    }
}
?>