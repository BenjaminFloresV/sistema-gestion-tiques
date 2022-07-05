<?php

require_once __DIR__.'/../../config.php';

use \PHPUnit\Framework\TestCase;
use SistemaTique\Mvc\Models\Tique;

class TiqueTest extends TestCase
{
    /** @test  */
    public function create()
    {
        $tique = new Tique();
        $fakeData = [
            'id_usuario_crea' => 1,
            'rut_cliente' => '13008100-2',
            'id_tipo' => 1,
            'id_area' => 1,
            'id_criticidad' => 1,
            'fecha_creacion' => '2022-04-12',
            'detalle_problema' => 'Cliente no tiene transformador de energía para su notebook',
            'detalle_servicio' => 'El servicio consta de proporcionar el transformador necesario y limpieza del aparato'

        ];
        $tique->storeFormValues($fakeData);
        $create = $tique->create();

        $this->assertEquals(true, $create);
    }
}