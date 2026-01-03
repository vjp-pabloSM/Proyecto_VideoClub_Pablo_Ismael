<?php

namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\interfaz\Resumible;

/**
 * Clase abstracta Soporte
 *
 * Representa un soporte audiovisual del videoclub.
 * Es la clase base de DVDs, cintas de vídeo y juegos.
 * Implementa la interfaz Resumible.
 *
 * @package Dwes\ProyectoVideoclub
 */
abstract class Soporte implements Resumible {
    /**
     * Título del soporte
     *
     * @var string
     */
    public string $titulo = "";

    /**
     * Indica si el soporte está alquilado
     *
     * @var bool
     */
    public bool $alquilado = false;

    /**
     * Número identificador del soporte
     *
     * @var int
     */
    protected int $numero = 0;

    /**
     * Precio base del soporte (sin IVA)
     *
     * @var float
     */
    private float $precio = 0;

    /**
     * IVA aplicado al precio del soporte
     *
     * @var float
     */
    private const IVA = 0.21;

    /**
     * URL de Metacritic del soporte
     *
     * @var string
     */
    protected string $metacritic;

    /**
     * Constructor de la clase Soporte
     *
     * @param string $titulo Título del soporte
     * @param int    $numero Identificador del soporte
     * @param float  $precio Precio base sin IVA
     */
    public function __construct(string $titulo, int $numero, float $precio, string $metacritic) {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
        $this->metacritic = $metacritic;

    }

    /**
     * Devuelve el precio base del soporte
     *
     * @return float
     */
    public function getPrecio(): float {
        return $this->precio;
    }

    /**
     * Devuelve el precio del soporte con IVA aplicado
     *
     * @return float
     */
    public function getPrecioConIva(): float {
        return round($this->precio * (1 + self::IVA), 2);
    }

    /**
     * Devuelve el número identificador del soporte
     *
     * @return int
     */
    public function getNumero(): int {
        return $this->numero;
    }

    /**
     * Devuelve la URL de Metacritic
     *
     * @return string
     */
    public function getMetacritic(): string {
        return $this->metacritic;
    }

    /**
     * Obtiene la puntuación del soporte desde Metacritic
     *
     * @return int|null Puntuación Metacritic o null si no se pudo obtener
     */
    abstract public function getPuntuacion(): ?int;

    /**
     * Realiza el scraping de la puntuación Metacritic
     *
     * @return int|null
     */
    protected function scrapMetacritic(): ?int {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: Mozilla/5.0\r\n"
            ]
        ]);

        $html = @file_get_contents($this->metacritic, false, $context);

        if ($html === false) {
            return null;
        }

        // Nuevo formato Metacritic (2024+)
        if (preg_match('/title="Metascore\s+(\d+)\s+out of 100"/i', $html, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }


    /**
     * Muestra un resumen del soporte
     *
     * Método que deben implementar las clases hijas.
     *
     * @return void
     */
    abstract public function muestraResumen(): void;
}
