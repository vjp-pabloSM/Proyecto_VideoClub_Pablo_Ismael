<?php
namespace Dwes\ProyectoVideoclub;

use Psr\Log\LoggerInterface;
use Dwes\ProyectoVideoclub\Util\LogFactory;
use Dwes\ProyectoVideoclub\Util\VideoclubException;
use Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

/**
 * Clase Videoclub
 *
 * Gestiona los productos (soportes) y socios de un videoclub,
 * así como los alquileres y devoluciones.
 * Actúa como clase central de coordinación entre Cliente y Soporte.
 *
 * @package Dwes\ProyectoVideoclub
 */
class Videoclub {

    /**
     * Nombre del videoclub
     *
     * @var string
     */
    private $nombre;

    /**
     * Lista de productos disponibles en el videoclub
     *
     * @var Soporte[]
     */
    private $productos = [];

    /**
     * Número total de productos
     *
     * @var int
     */
    private $numProductos = 0;

    /**
     * Lista de socios del videoclub
     *
     * @var Cliente[]
     */
    private $socios = [];

    /**
     * Número total de socios
     *
     * @var int
     */
    private $numSocios = 0;

    /**
     * Número de productos actualmente alquilados
     *
     * @var int
     */
    private $numProductosAlquilados = 0;

    /**
     * Número total de alquileres realizados
     *
     * @var int
     */
    private $numTotalAlquileres = 0;

    /**
     * Logger para registrar eventos del videoclub
     *
     * @var LoggerInterface
     */
    private LoggerInterface $log;

    /**
     * Constructor de la clase Videoclub
     *
     * @param string $nombre Nombre del videoclub
     */
    public function __construct($nombre) {
        $this->nombre = $nombre;
        $this->log = LogFactory::createLogger();
    }

    /**
     * Añade un producto (soporte) al videoclub
     *
     * @param Soporte $producto Producto a incluir
     * @return void
     */
    public function incluirProducto(Soporte $producto) {
        $this->productos[] = $producto;
        $this->numProductos++;

        $this->log->info(
            'Producto añadido al videoclub',
            [
                'producto' => get_class($producto),
                'numeroProducto' => $producto->getNumero()
            ]
        );
    }

    /**
     * Crea e incluye una cinta de vídeo en el videoclub
     *
     * @param string $titulo
     * @param float  $precio
     * @param int    $duracion
     * @return void
     */
    public function incluirCintaVideo(string $metacritic, $titulo, $precio, $duracion) {
        $cinta = new CintaVideo($titulo, $this->numProductos + 1, $precio, $metacritic, $duracion);
        $this->incluirProducto($cinta);
    }

    /**
     * Crea e incluye un DVD en el videoclub
     *
     * @param string $titulo
     * @param float  $precio
     * @param string $idiomas
     * @param string $pantalla
     * @return void
     */
    public function incluirDvd(string $metacritic, $titulo, $precio, $idiomas, $pantalla) {
        $dvd = new Dvd($titulo, $this->numProductos + 1, $precio, $metacritic, $idiomas, $pantalla);
        $this->incluirProducto($dvd);
    }

    /**
     * Crea e incluye un juego en el videoclub
     *
     * @param string $titulo
     * @param float  $precio
     * @param string $consola
     * @param int    $minJ
     * @param int    $maxJ
     * @return void
     */
    public function incluirJuego(string $metacritic, $titulo, $precio, $consola, $minJ, $maxJ) {
        $juego = new Juego($titulo, $this->numProductos + 1, $precio, $metacritic, $consola, $minJ, $maxJ);
        $this->incluirProducto($juego);
    }

    /**
     * Añade un socio al videoclub
     *
     * @param string $nombre
     * @param int    $maxAlquilerConcurrente
     * @return void
     */
    public function incluirSocio($nombre, $maxAlquilerConcurrente = 3) {
        $cliente = new Cliente($nombre, $this->numSocios + 1, '', '', $maxAlquilerConcurrente);
        $this->socios[] = $cliente;
        $this->numSocios++;

        $this->log->info(
            'Socio añadido al videoclub',
            [
                'cliente' => $nombre,
                'numeroCliente' => $this->numSocios
            ]
        );
    }

    /**
     * Muestra la lista de productos del videoclub
     *
     * @return void
     */
    public function listarProductos() {
        echo "<h3>Lista de productos del VideoClub {$this->nombre}</h3>";

        if (empty($this->productos)) {
            echo "<p>No hay productos en el videoclub</p>";
            return;
        }

        foreach ($this->productos as $producto) {
            $producto->muestraResumen();
            echo "<br>";
        }
    }

    /**
     * Muestra la lista de socios del videoclub
     *
     * @return void
     */
    public function listarSocios() {
        echo "<h3>Lista de socios del VideoClub {$this->nombre}</h3>";

        if (empty($this->socios)) {
            echo "<p>No hay socios en el videoclub</p>";
            return;
        }

        foreach ($this->socios as $socio) {
            $socio->muestraResumen();
        }
    }

    /**
     * Devuelve la lista de socios
     *
     * @return Cliente[]
     */
    public function getSocios(): array {
        return $this->socios;
    }

    /**
     * Devuelve el número de productos actualmente alquilados
     *
     * @return int
     */
    public function getNumProductosAlquilados(): int {
        return $this->numProductosAlquilados;
    }

    /**
     * Devuelve el número total de alquileres realizados
     *
     * @return int
     */
    public function getNumTotalAlquileres(): int {
        return $this->numTotalAlquileres;
    }

    /**
     * Alquila un producto a un socio
     *
     * Captura las excepciones lanzadas por Cliente y registra logs.
     *
     * @param int $numeroCliente
     * @param int $numeroSuporte
     * @return Videoclub
     */
    public function alquilarSocioProducto(int $numeroCliente, int $numeroSoporte): Videoclub {
        $cliente = null;
        $soporte = null;

        // Buscar cliente
        foreach ($this->socios as $s) {
            if ($s->getNumero() === $numeroCliente) {
                $cliente = $s;
                break;
            }
        }

        // Buscar soporte
        foreach ($this->productos as $p) {
            if ($p->getNumero() === $numeroSoporte) {
                $soporte = $p;
                break;
            }
        }

        // Si no existe cliente o soporte, lanzamos excepción
        if (!$cliente) {
            throw new ClienteNoEncontradoException("Cliente con número $numeroCliente no encontrado.");
        }
        if (!$soporte) {
            throw new SoporteNoEncontradoException("Soporte con número $numeroSoporte no encontrado.");
        }

        try {
            $cliente->alquilar($soporte);
            $this->numProductosAlquilados++;
            $this->numTotalAlquileres++;
        } catch (VideoclubException $e) {
            // Se captura la excepción para no romper la ejecución
        }

        return $this;
    }


    /**
     * Alquila múltiples productos a un socio
     *
     * @param int   $numSocio
     * @param int[] $numerosProductos
     * @return Videoclub
     */
    public function alquilarSocioProductos(int $numSocio, array $numerosProductos) {
        return $this;
    }

    /**
     * Devuelve un producto alquilado por un socio
     *
     * @param int $numSocio
     * @param int $numeroProducto
     * @return Videoclub
     */
    public function devolverSocioProducto(int $numSocio, int $numeroProducto) {
        $cliente = null;

        // Buscar cliente
        foreach ($this->socios as $s) {
            if ($s->getNumero() === $numSocio) {
                $cliente = $s;
                break;
            }
        }

        if (!$cliente) {
            throw new ClienteNoEncontradoException("Cliente con número $numSocio no encontrado.");
        }

        $cliente->devolver($numeroProducto);

        return $this;
    }

    /**
     * Devuelve múltiples productos alquilados por un socio
     *
     * @param int   $numSocio
     * @param int[] $numerosProductos
     * @return Videoclub
     */
    public function devolverSocioProductos(int $numSocio, array $numerosProductos) {
        return $this;
    }
}
