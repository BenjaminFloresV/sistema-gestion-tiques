<?php

namespace SistemaTique\Mvc\Controllers\Roles;

use SistemaTique\Helpers\FormVerifier;
use SistemaTique\Helpers\Helpers;
use SistemaTique\Middleware\RenderView;
use SistemaTique\Mvc\Models\Area;
use SistemaTique\Mvc\Models\Criticidad;
use SistemaTique\Mvc\Models\Tique;

class EjecutivoAreaController
{
    public function manageTiques( string $action = null)
    {

        Helpers::isAdmin(3);
        $action = Helpers::verifyAction($action);
        $data = Helpers::retrieveObjectData($action, [new Tique(), 'getAllFiltered'], ['filterByAreaAndState' => ['id_area' => $_SESSION['user']['id_area'], 'id_estado' => 1], 'includeClientInfo' => true]);
        $selectsData = Helpers::retrieveSelectsData(
            [
                [new Tique(), 'getStates', 'estadosTique'],
            ]
        );


        RenderView::render('admin-panel',
            [
                'manageView' => 'Tiques/'.$action,
                'selectsData' => $selectsData,
                'data' => $data
            ]
        );
    }


    public function showHome()
    {
        RenderView::render('admin-panel');
    }
}