<?php
namespace Dwes\ProyectoVideoclub\Tests;

use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\Videoclub;
use Dwes\ProyectoVideoclub\Util\ClienteNoExisteException;

class ClienteNoExisteExceptionTest extends TestCase
{
    public function testAlquilarClienteNoExiste()
    {
        $vc = new Videoclub("Mi Videoclub");

        $this->expectException(ClienteNoExisteException::class);

        $vc->alquilarSocioProducto(99, 1); // Cliente 99 no existe
    }

    public function testDevolverClienteNoExiste()
    {
        $vc = new Videoclub("Mi Videoclub");

        $this->expectException(ClienteNoExisteException::class);

        $vc->devolverSocioProducto(99, 1); // Cliente 99 no existe
    }
}
