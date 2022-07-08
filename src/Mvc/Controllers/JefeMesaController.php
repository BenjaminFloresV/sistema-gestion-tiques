<?php

namespace SistemaTique\Mvc\Controllers;

use SistemaTique\Helpers\Helpers;
use SistemaTique\Middleware\RenderView;
use SistemaTique\Mvc\Models\Area;
use SistemaTique\Mvc\Models\Criticidad;
use SistemaTique\Mvc\Models\Tique;
use SistemaTique\Mvc\Models\User;

class JefeMesaController
{
    public function manageUsuarios(string $action = null)
    {
        $action = Helpers::verifyAction($action);
        $needsSelects = Helpers::verifySelects($action);
        $selectsData = null;

        if( $needsSelects ){
            $selectsData = Helpers::retrieveSelectsData(
                [
                    [new User(), 'getUserTypes', 'tiposUsuarios'],
                    [new Area(), 'getAll', 'tipoAreas']
                ]
            );
        }

        $data = Helpers::retrieveObjectData( $action, [new User(), 'getAll'] );

        RenderView::render('admin-panel',
            [
                'manageView' => 'Usuarios/'.$action,
                'selectsData' => $selectsData,
                'data' => $data
            ]
        );
    }

    public function manageCriticidad( string $action = null )
    {
        $action = Helpers::verifyAction($action);

        $data = Helpers::retrieveObjectData( $action, [new Criticidad(), 'getAll'] );

        RenderView::render('admin-panel',
            [
                'manageView' => 'Criticidad/'.$action,
                'data' => $data
            ]
        );
    }


    public function manageAreas( string $action = null )
    {

        $action = Helpers::verifyAction($action);

        $data = Helpers::retrieveObjectData( $action, [new Area(), 'getAll'] );

        RenderView::render('admin-panel',
            [
                'manageView' => 'Areas/'.$action,
                'data' => $data
            ]
        );

    }

    public function manageTiposTique( string $action = null )
    {
        $action = Helpers::verifyAction($action);

        $data = Helpers::retrieveObjectData($action, [new Tique(), 'getTiqueTypes']);

        RenderView::render('admin-panel',
            [
                'manageView' => 'TiposTique/'.$action,
                'data' => $data
            ]
        );


    }


}