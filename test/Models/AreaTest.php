<?php

require_once __DIR__.'/../../config.php';

use \PHPUnit\Framework\TestCase;
use SistemaTique\Mvc\Models\Area;

class AreaTest extends TestCase
{
    /** @test */
    public function getAll()
    {
        $area = new Area();
        $areas = $area->getAll();

        $this->assertEquals('array', gettype($areas));
        $this->assertEquals(true, count($areas) > 0);
    }

    public function create()
    {
        $area = new Area();
        $area->setNombre('Bases de Datos');
        $create = $area->create();

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
}