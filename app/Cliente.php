<?php
namespace Dwes\ProyectoVideoclub;

use Psr\Log\LoggerInterface;
use Dwes\ProyectoVideoclub\Util\LogFactory;

use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

/**
 * Clase Cliente
 *
 * Representa un socio del videoclub.
 * Gestiona los alquileres de soportes, controlando el cupo máximo
 * y lanzando excepciones cuando se producen errores.
 *
 * @package Dwes\ProyectoVideoclub
 */
class Cliente {

    /**
     * Nombre del cliente
     *
     * @var string
     */
    public $nombre = "";

    /**
     * Número identificador del cliente
     *
     * @var int
     */
    private $numero = 0;

    /**
     * Soportes actualmente alquilados por el cliente
     *
     * @var Soporte[]
     */
    private $soportesAlquilados = [];

    /**
     * Número de soportes alquilados actualmente
     *
     * @var int
     */
    private $numSoportesAlquilados = 0;

    /**
     * Máximo de alquileres concurrentes permitidos
     *
     * @var int
     */
    private $maxAlquilerConcurrente;

    /**
     * Usuario de acceso del cliente
     *
     * @var string
     */
    private $user = "";

    /**
     * Contraseña del cliente
     *
     * @var string
     */
    private $password = "";

    /**
     * Logger del cliente
     *
     * @var LoggerInterface
     */
    private LoggerInterface $log;

    /**
     * Constructor de la clase Cliente
     *
     * @param string $nombre
     * @param int    $numero
     * @param string $user
     * @param string $password
     * @param int    $maxAlquilerConcurrente
     */
    public function __construct(
        $nombre,
        $numero,
        $user = '',
        $password = '',
        $maxAlquilerConcurrente = 3
    ) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->user = $user;
        $this->password = $password;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
        $this->soportesAlquilados = [];
        $this->log = LogFactory::createLogger();
    }

    /* =====================
     * Getters y Setters
     * ===================== */

    /**
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return void
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param string $user
     * @return void
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getNumero() {
        return $this->numero;
    }

    /**
     * @param int $numero
     * @return void
     */
    public function setNumero($numero) {
        $this->numero = $numero;
    }

    /**
     * Devuelve los soportes alquilados
     *
     * @return Soporte[]
     */
    public function getSoportesAlquilados() {
        return $this->soportesAlquilados;
    }

    /**
     * Alias de getSoportesAlquilados()
     *
     * @return Soporte[]
     */
    public function getAlquileres(): array {
        return $this->soportesAlquilados;
    }

    /* =====================
     * Métodos de alquiler
     * ===================== */

    /**
     * Comprueba si el cliente tiene alquilado un soporte
     *
     * @param Soporte $s
     * @return bool
     */
    public function tieneAlquilado(Soporte $s): bool {
        foreach ($this->soportesAlquilados as $soporte) {
            if ($soporte->getNumero() === $s->getNumero()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Alquila un soporte al cliente
     *
     * @param Soporte $s
     * @return Cliente
     *
     * @throws SoporteYaAlquiladoException
     * @throws CupoSuperadoException
     */
    public function alquilar(Soporte $s) {
        if ($this->tieneAlquilado($s)) {
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

        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++;
        $s->alquilado = true;

        $this->log->info(
            'Soporte alquilado correctamente',
            [
                'cliente' => $this->nombre,
                'numeroCliente' => $this->numero,
                'soporte' => $s->getNumero()
            ]
        );

        $s->muestraResumen();
        return $this;
    }

    /**
     * Devuelve un soporte alquilado por su número
     *
     * @param int $numSoporte
     * @return Cliente
     *
     * @throws SoporteNoEncontradoException
     */
    public function devolver(int $numSoporte) {
        foreach ($this->soportesAlquilados as $indice => $soporte) {
            if ($soporte->getNumero() == $numSoporte) {
                unset($this->soportesAlquilados[$indice]);
                $this->soportesAlquilados = array_values($this->soportesAlquilados);
                $soporte->alquilado = false;

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

    /**
     * Lista los alquileres actuales del cliente
     *
     * @return void
     */
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

    /**
     * Muestra un resumen del cliente
     *
     * @return void
     */
    public function muestraResumen() {
        echo "<p>Cliente: {$this->nombre}<br>Nº cliente: {$this->numero}<br>Soportes alquilados: " . count($this->soportesAlquilados) . " de {$this->maxAlquilerConcurrente} posibles.</p>";
    }
}
