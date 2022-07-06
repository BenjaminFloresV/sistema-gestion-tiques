<?php

namespace SistemaTique\Mvc\Controllers;

use SistemaTique\Helpers\Helpers;
use SistemaTique\Middleware\RenderView;
use SistemaTique\Mvc\Models\Area;
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


}