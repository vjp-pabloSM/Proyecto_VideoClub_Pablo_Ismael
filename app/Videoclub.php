<?php
namespace Dwes\ProyectoVideoclub;

use Psr\Log\LoggerInterface;
use Dwes\ProyectoVideoclub\Util\LogFactory;

use Dwes\ProyectoVideoclub\Util\VideoclubException;

// Clase videoclub que relaciona las clases cliente y soporte
class Videoclub{
    private $nombre;
    private $productos = [];
    private $numProductos = 0;
    private $socios = [];
    private $numSocios = 0;

    // Atributos para seguimiento de alquileres
    private $numProductosAlquilados = 0;
    private $numTotalAlquileres = 0;

    // Atributo para los logs
    private LoggerInterface $log;

    // Constructor que solo recibe $nombre porque es lo único que se necesita para crear el videoclub
    public function __construct($nombre){
        $this->nombre = $nombre;
        $this->log = LogFactory::createLogger();
    }

    // Método que incluye Productos del array de soporte al videoclub
    public function incluirProducto(Soporte $producto){
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
    
    // Método que incluye las cintas de video al videoclub
    public function incluirCintaVideo($titulo, $precio, $duracion){
        $cinta = new CintaVideo($titulo, $this->numProductos + 1, $precio,$duracion);
        $this->incluirProducto($cinta);
    }

    // Método que incluye los dvd al videoclub
    public function incluirDvd($titulo, $precio, $idiomas, $pantalla){
        $dvd = new Dvd($titulo, $this->numProductos + 1, $precio,$idiomas, $pantalla);
        $this->incluirProducto($dvd);
    }

    // Método que incluye los Juegos al videoclub
    public function incluirJuego($titulo, $precio, $consola, $minJ, $maxJ){
        $juego = new Juego($titulo, $this->numProductos + 1, $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($juego);
    }

    // Método para incluir los socios
    public function incluirSocio($nombre, $maxAlquilerConcurrente = 3) {
        $cliente = new Cliente($nombre, $this->numSocios+1, $maxAlquilerConcurrente);
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

    // Método que muestra los productos en una lista
    public function listarProductos() {
        echo "<h3>Lista de productos del VideoClub " . $this->nombre . "</h3>";

        if (empty($this->productos)) {
            echo "<p>No hay productos en el videoclub</p>";
        } else {
            foreach ($this->productos as $producto) {
                $producto->muestraResumen();
                echo "<br>";
            }
        }
    }

    // Método que muestra la lista de socios
    public function listarSocios() {
        echo "<h3>Lista de socios del VideoClub " . $this->nombre . "</h3>";

        if (empty($this->socios)) {
            echo "<p>No hay socios en el videoclub</p>";
        } else {
            foreach ($this->socios as $socio) {
                $socio->muestraResumen();
            }
        }
    }

    // getters para las nuevas propiedades
    public function getNumProductosAlquilados(): int {
        return $this->numProductosAlquilados;
    }

    // Devuelve el total de alquileres realizados
    public function getNumTotalAlquileres(): int {
        return $this->numTotalAlquileres;
    }

    // Método para alquilarle productos a los socios (ahora captura excepciones lanzadas por Cliente)
    public function alquilarSocioProducto($numeroCliente, $numeroSuporte) {
        $cliente = null;
        $soporte = null;

        // Buscar cliente
        foreach ($this->socios as $s) {
            if ($s->getNumero() == $numeroCliente) {
                $cliente = $s;
                break;
            }
        }

        // Buscar soporte
        foreach ($this->productos as $p) {
            if ($p->getNumero() == $numeroSuporte) {
                $soporte = $p;
                break;
            }
        }

        // Cliente o soporte no encontrados
        if (!$cliente || !$soporte) {
            $this->log->warning(
                'Cliente o soporte no encontrado para alquiler',
                [
                    'cliente' => $numeroCliente,
                    'producto' => $numeroSuporte
                ]
            );

            return $this;
        }

        try {
            $soporteEstabaLibre = $soporte->alquilado ?? false;

            // Intentar alquilar (puede lanzar excepciones)
            $cliente->alquilar($soporte);

            // Actualizar contadores
            if (!$soporteEstabaLibre && ($soporte->alquilado ?? false)) {
                $this->numProductosAlquilados++;
            }

            $this->numTotalAlquileres++;

            // Log INFO si todo va bien
            $this->log->info(
                'Alquiler realizado correctamente desde Videoclub',
                [
                    'cliente' => $numeroCliente,
                    'producto' => $numeroSuporte
                ]
            );

        } catch (VideoclubException $e) {

            // Log WARNING al capturar la excepción
            $this->log->warning(
                'Error al alquilar producto desde Videoclub',
                [
                    'cliente' => $numeroCliente,
                    'producto' => $numeroSuporte,
                    'error' => $e->getMessage()
                ]
            );
        }

        return $this; // permite encadenamiento desde Videoclub
    }


    // Alquila múltiples productos a un socio    
    public function alquilarSocioProductos(int $numSocio, array $numerosProductos) {
        $cliente = null;
        $soportesSeleccionados = [];

        // Buscar socio
        foreach ($this->socios as $s) {
            if ($s->getNumero() == $numSocio) {
                $cliente = $s;
                break;
            }
        }

        if (!$cliente) {
            $this->log->warning(
                'Socio no encontrado para alquiler múltiple',
                ['cliente' => $numSocio]
            );
            return $this;
        }

        // Comprobar disponibilidad de todos los soportes
        foreach ($numerosProductos as $numProducto) {
            $soporte = null;

            foreach ($this->productos as $p) {
                if ($p->getNumero() == $numProducto) {
                    $soporte = $p;
                    break;
                }
            }

            if (!$soporte) {
                $this->log->warning(
                    'Soporte no encontrado en alquiler múltiple',
                    ['cliente' => $numSocio, 'producto' => $numProducto]
                );
                return $this;
            }

            if ($soporte->alquilado) {
                $this->log->warning(
                    'Soporte ya alquilado en alquiler múltiple',
                    ['cliente' => $numSocio, 'producto' => $numProducto]
                );
                return $this;
            }

            if ($cliente->tieneAlquilado($soporte)) {
                $this->log->warning(
                    'Cliente ya tenía alquilado el soporte (alquiler múltiple)',
                    ['cliente' => $numSocio, 'producto' => $numProducto]
                );
                return $this;
            }

            $soportesSeleccionados[] = $soporte;
        }

        // Alquilar todos los soportes
        foreach ($soportesSeleccionados as $soporte) {
            try {
                $cliente->alquilar($soporte);
                $this->numProductosAlquilados++;
                $this->numTotalAlquileres++;

                $this->log->info(
                    'Soporte alquilado en alquiler múltiple',
                    ['cliente' => $numSocio, 'producto' => $soporte->getNumero()]
                );

            } catch (VideoclubException $e) {
                $this->log->warning(
                    'Error al alquilar soporte en alquiler múltiple',
                    [
                        'cliente' => $numSocio,
                        'producto' => $soporte->getNumero(),
                        'error' => $e->getMessage()
                    ]
                );
            }
        }

        return $this;
    }

    // Devuelve un único producto de un socio
    public function devolverSocioProducto(int $numSocio, int $numeroProducto) {
        $cliente = null;
        $soporte = null;

        foreach ($this->socios as $s) {
            if ($s->getNumero() == $numSocio) {
                $cliente = $s;
                break;
            }
        }

        foreach ($this->productos as $p) {
            if ($p->getNumero() == $numeroProducto) {
                $soporte = $p;
                break;
            }
        }

        if ($cliente && $soporte) {
            try {
                $cliente->devolver($numeroProducto);
                if ($this->numProductosAlquilados > 0) {
                    $this->numProductosAlquilados--;
                }

                $this->log->info(
                    'Soporte devuelto desde Videoclub',
                    ['cliente' => $numSocio, 'producto' => $numeroProducto]
                );

            } catch (VideoclubException $e) {
                $this->log->warning(
                    'Error al devolver soporte desde Videoclub',
                    [
                        'cliente' => $numSocio,
                        'producto' => $numeroProducto,
                        'error' => $e->getMessage()
                    ]
                );
            }
        } else {
            $this->log->warning(
                'Cliente o soporte no encontrado al devolver',
                ['cliente' => $numSocio, 'producto' => $numeroProducto]
            );
        }

        return $this;
    }

    // Devuelve múltiples productos de un socio
    public function devolverSocioProductos(int $numSocio, array $numerosProductos) {
        $cliente = null;
        $soportesParaDevolver = [];

        // Buscar cliente
        foreach ($this->socios as $s) {
            if ($s->getNumero() == $numSocio) {
                $cliente = $s;
                break;
            }
        }

        if (!$cliente) {
            $this->log->warning(
                'Cliente no encontrado en devolución múltiple',
                ['cliente' => $numSocio]
            );
            return $this;
        }

        // Verificar soportes
        foreach ($numerosProductos as $numProd) {
            $soporte = null;

            foreach ($this->productos as $p) {
                if ($p->getNumero() == $numProd) {
                    $soporte = $p;
                    break;
                }
            }

            if (!$soporte || !$cliente->tieneAlquilado($soporte)) {
                $this->log->warning(
                    'Error en devolución múltiple: soporte no alquilado',
                    ['cliente' => $numSocio, 'producto' => $numProd]
                );
                return $this;
            }

            $soportesParaDevolver[] = $soporte;
        }

        // Devolver todos
        foreach ($soportesParaDevolver as $s) {
            $cliente->devolver($s->getNumero());
            if ($this->numProductosAlquilados > 0) {
                $this->numProductosAlquilados--;
            }

            $this->log->info(
                'Soporte devuelto en devolución múltiple',
                ['cliente' => $numSocio, 'producto' => $s->getNumero()]
            );
        }

        return $this;
    }

}
?>