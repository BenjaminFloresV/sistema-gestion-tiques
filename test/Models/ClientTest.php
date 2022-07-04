<?php

require_once __DIR__.'/../../config.php';

use SistemaTique\Mvc\Models\Client;
use  \PHPUnit\Framework\TestCase;
use SistemaTique\Helpers\NewLogger;

class ClientTest extends TestCase
{


    public function storeFormValues()
    {
        $client = new Client();
        $fakeData = array(
            'nombre' => 'Benjamin',
            'rut' => '12008100-2',
            'apellido' => 'Flores'
        );

        $saveData = $client->storeFormValues($fakeData);

        $this->assertEquals(true, $saveData);

    }

    public function getClientInfo()
    {
        $client = new Client();
        $client->setRutCliente('13008100-2');
        $clientData = $client->getClientInfo();

        $this->assertEquals('object', gettype($clientData));

    }


    public function create()
    {
        $logger = NewLogger::newLogger('CLIENT_TEST_CREATE');
        $logger->debug('Test: trying to create a client');
        $client = new Client();
        $fakeData = [
            'rut_cliente' => '9696147-2',
            'nombre' => 'Ramon',
            'apellido' => 'Flores',
            'fecha_nacimiento' => '2000-01-12',
            'telefono' => '888888888',
            'correo' => 'ramon@flores'
        ];
        $client->storeFormValues($fakeData);
        $create = $client->create();
        // The second test will be an error because rut_cliente is a primary key, there is no auto-increment pk
        $this->assertEquals(true, $create);
    }

    /** @test */
    public function update()
    {
        $client = new Client();
        $client->setRutCliente('9696147-2');
        $fakeData = [
            'nombre' => 'Ramon',
            'apellido' => 'Flores',
            'fecha_nacimiento' => '2000-01-12',
            'telefono' => '888888888',
        ];
        $update = $client->update($fakeData);

        $this->assertEquals(true, $update);
    }


}