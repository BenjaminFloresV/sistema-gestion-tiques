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
        $tique = new Tique();
        $tique->setIdArea($_SESSION['user']['id_area']);
        $stats = $tique->getAvailableStats();

        $totalTiques = 0;
        $totalResolucion = 0;
        foreach ($stats as $stat) {
            $totalTiques += $stat['cantidad'];
            if( $stat['nombre'] == 'A resolución' ) {
                $totalResolucion =$stat['cantidad'];
            }
        }

        $finishedTiques = $totalTiques - $totalResolucion;

        $tiqueStats = ['totalTiques' => $totalTiques, 'availableTiques' => $totalResolucion, 'finishedTiques' => $finishedTiques];

        RenderView::render('admin-panel', [
            'tiqueStats' => $tiqueStats
        ]);
    }

    public function showProfile()
    {
        RenderView::render('admin-panel',[
            'profileData' => $_SESSION['user'],
            'profileView' => 'profile'
        ]);
    }



}