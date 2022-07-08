<?php

require_once __DIR__.'/../../config.php';

use \PHPUnit\Framework\TestCase;
use SistemaTique\Mvc\Models\Area;

class AreaTest extends TestCase
{

    public function getAll()
    {
        $area = new Area();
        $areas = $area->getAll();

        $this->assertEquals('array', gettype($areas));
        $this->assertEquals(true, count($areas) > 0);
    }


    public function create()
    {
        $logger = \SistemaTique\Helpers\NewLogger::newLogger('AREA_MODEL_TEST');
        $area = new Area();
        $area->setNombre('Bases de Datos');
        $create = $area->create();

        $logger->debug('Query result', array('result' => $create));

        $this->assertEquals(true, $create);
    }

    public function update()
    {
        $area = new Area();
        $area->setId_area(1);
        $area->setNombre('Servicio Tecnológico');

        $update = $area->update();


        $this->assertEquals(true, $update);
    }



    public function isInUse()
    {
        $area = new Area();
        $area->setId_area(11);
        $checkUsage = $area->idInUse();

        $this->assertEquals(true, $checkUsage);

    }

    /** @test */
    public function delete()
    {
        $area = new Area();
        $area->setId_area(1);

        $delete = $area->delete();

        $this->assertEquals(true, $delete);
    }
}