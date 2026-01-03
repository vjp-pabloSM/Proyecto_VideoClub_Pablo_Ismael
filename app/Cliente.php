<?php
namespace Dwes\ProyectoVideoclub;

use Psr\Log\LoggerInterface;
use Dwes\ProyectoVideoclub\Util\LogFactory;

use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

// Clase Cliente
class Cliente {

    // Propiedades públicas y privadas del cliente
    public $nombre = "";                   
    private $numero = 0;                   
    private $soportesAlquilados = [];      
    private $numSoportesAlquilados = 0;      
    private $maxAlquilerConcurrente;        
    private $user = "";                    
    private $password = "";

    // Atributo para los logs
    private LoggerInterface $log;

    // Constructor para inicializar un cliente
    public function __construct($nombre, $numero, $user = '', $password = '', $maxAlquilerConcurrente = 3) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->user = $user;
        $this->password = $password;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
        $this->soportesAlquilados = []; // Inicializa array vacío de alquileres
        $this->log = LogFactory::createLogger();
    }
    
    // Getters y setters 
    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getUser() { return $this->user; }
    public function setUser($user) { $this->user = $user; }

    public function getPassword() { return $this->password; }
    public function setPassword($password) { $this->password = $password; }

    public function getNumero() { return $this->numero; }
    public function setNumero($numero) { $this->numero = $numero; }

    public function getSoportesAlquilados() { return $this->soportesAlquilados; }
    public function getAlquileres(): array { return $this->soportesAlquilados; }

    // Métodos de alquiler 
    // Comprobar si el cliente ya tiene alquilado un soporte
    public function tieneAlquilado(Soporte $s): bool {
        foreach ($this->soportesAlquilados as $soporte) {
            if ($soporte->getNumero() === $s->getNumero()) return true;
        }
        return false;
    }

    // Alquila un soporte, lanzando excepciones si hay problemas
    public function alquilar(Soporte $s) {
        if ($this->tieneAlquilado($s)) {

            // Log warning antes de lanzar la excepción
            $this->log->warning(
                'Intento de alquilar soporte ya alquilado',
                [
                    'cliente' => $this->nombre,
                    'numeroCliente' => $this->numero,
                    'soporte' => $s->getNumero()
                ]
            );

            throw new SoporteYaAlquiladoException(
                "El cliente {$this->nombre} (nº {$this->numero}) ya tiene alquilado el soporte nº {$s->getNumero()}."
            );
        }

        if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {

            // Log warning antes de lanzar la excepción
            $this->log->warning(
                'Cupo de alquiler superado',
                [
                    'cliente' => $this->nombre,
                    'numeroCliente' => $this->numero,
                    'maxAlquileres' => $this->maxAlquilerConcurrente
                ]
            );

            throw new CupoSuperadoException(
                "El cliente {$this->nombre} (nº {$this->numero}) ha alcanzado el máximo de alquileres ({$this->maxAlquilerConcurrente})."
            );
        }

        // Agrega el soporte al array de alquileres
        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++;
        $s->alquilado = true;

        // Log info del alquiler realizado
        $this->log->info(
            'Soporte alquilado correctamente',
            [
                'cliente' => $this->nombre,
                'numeroCliente' => $this->numero,
                'soporte' => $s->getNumero()
            ]
        );

        // Mostrar resumen del alquiler
        $s->muestraResumen();
        return $this;
    }

    // Devuelve un soporte por número de soporte
    public function devolver(int $numSoporte) {
        foreach ($this->soportesAlquilados as $indice => $soporte) {
            if ($soporte->getNumero() == $numSoporte) {
                unset($this->soportesAlquilados[$indice]);
                $this->soportesAlquilados = array_values($this->soportesAlquilados); 
                $soporte->alquilado = false;
                // Log info de la devolución
                $this->log->info(
                    'Soporte devuelto',
                    [
                        'cliente' => $this->nombre,
                        'numeroCliente' => $this->numero,
                        'soporte' => $numSoporte
                    ]
                );
                return $this;
            }
        }

        // Log warning antes de lanzar la excepción
        $this->log->warning(
            'Intento de devolver soporte no alquilado',
            [
                'cliente' => $this->nombre,
                'numeroCliente' => $this->numero,
                'soporte' => $numSoporte
            ]
        );

        throw new SoporteNoEncontradoException(
            "El cliente {$this->nombre} (nº {$this->numero}) no tenía alquilado el soporte nº {$numSoporte}."
        );
    }

    // Listar todos los alquileres del cliente
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

    // Muestra un resumen general del cliente
    public function muestraResumen() {
        echo "<p>Cliente: {$this->nombre}<br>Nº cliente: {$this->numero}<br>Soportes alquilados: " 
            . count($this->soportesAlquilados) . " de {$this->maxAlquilerConcurrente} posibles.</p>";
    }

}
?>
