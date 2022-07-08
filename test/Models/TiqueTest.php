<?php

require_once __DIR__.'/../../config.php';

use \PHPUnit\Framework\TestCase;
use SistemaTique\Mvc\Models\Tique;

class TiqueTest extends TestCase
{

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


    public function getTiqueTypes()
    {
        $tique = new Tique();
        $tiqueTypes = $tique->getTiqueTypes();

        $this->assertEquals('array', gettype($tiqueTypes));
    }


    public function createTipoTique()
    {
        $tique = new Tique();
        $tique->setNombreTipoTique('Emergencia');
        $newTipoTique= $tique->createTipo();

        $this->assertEquals(true, $newTipoTique);
    }

    public function updateTipo()
    {
        $tique = new Tique();
        $tique->setIdTipoTique(1);
        $tique->setNombreTipoTique('Felicitación');

        $updateTipoTique =$tique->updateTipo();


        $this->assertEquals(true, $updateTipoTique);
    }



    public function tipoTiqueIsUsed()
    {
        $tique = new Tique();
        $tique->setIdTipoTique(100);

        $isUsed = $tique->idInUse();

        $this->assertEquals(true, $isUsed);

    }

    /** @test  */
    public function deleteTipo()
    {
        $tique = new Tique();
        $tique->setIdTipoTique(8);
        $result = false;
        $isUsed = $tique->idInUse();

        if( !$isUsed ) {
            $result = $tique->deleteTipo();
        }

        $this->assertEquals(true, $result);
    }
}