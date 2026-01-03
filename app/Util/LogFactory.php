<?php

namespace Dwes\ProyectoVideoclub\Util;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

// Factoría encargada de crear y configurar el logger de la aplicación
class LogFactory
{
    // Crea y devuelve un logger
    public static function createLogger(): LoggerInterface
    {
        // Se crea el logger con un canal común para todo el videoclub
        $logger = new Logger('VideoclubLogger');

        // Se añade un handler que escribe los mensajes en el archivo videoclub.log
        $logger->pushHandler(
            new StreamHandler(__DIR__ . '/../../logs/videoclub.log', Logger::DEBUG)
        );

        // Se devuelve el logger ya configurado
        return $logger;
    }
}
