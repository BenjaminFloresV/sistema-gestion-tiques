<?php


require_once __DIR__.'/../../config.php';

use \PHPUnit\Framework\TestCase;
use SistemaTique\Mvc\Models\Criticidad;
use SistemaTique\Helpers\NewLogger;

class CriticidadTest extends TestCase
{

    public function getAll()
    {
        $logger = NewLogger::newLogger('CRTICIDAD_TEST_GET_ALL');
        $criticidad = new Criticidad();
        $criticidades = $criticidad->getAll();

        $this->assertEquals('array', gettype($criticidades));
        $logger->debug('Data collected', array('data'=>$criticidades));
    }


    public function create()
    {
        $criticiad = new Criticidad();
        $criticiad->setNombre( 'Normal' );
        $criticiad->setValor( 10 );

        $create = $criticiad->create();

        $this->assertEquals( true, $create );
    }

    /** @test */
    public function update()
    {
        $criticidad = new Criticidad();
        $criticidad->setIdCriticidad(1);
        $criticidad->setNombre('Urgente');
        $criticidad->setValor(15);

        $update = $criticidad->update();

        $this->assertEquals(true, $update);
    }

}