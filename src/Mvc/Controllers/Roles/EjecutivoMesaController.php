<?php

namespace SistemaTique\Mvc\Controllers\Roles;

use SistemaTique\Helpers\Helpers;
use SistemaTique\Middleware\RenderView;
use SistemaTique\Mvc\Models\Area;
use SistemaTique\Mvc\Models\Criticidad;
use SistemaTique\Mvc\Models\Tique;

class EjecutivoMesaController
{
    public function manageTiques(string $action = null)
    {
        Helpers::isAdmin(1);
        $action = Helpers::verifyAction($action);
        $selectsData = null;

        if( isset($_SESSION['clientInfo'])) {
            $selectsData = Helpers::retrieveSelectsData(
                [
                    [new Tique(), 'getTiqueTypes', 'tiposTique'],
                    [new Area(), 'getAll', 'tipoAreas'],
                    [new Criticidad(), 'getAll', 'criticidades']
                ]
            );
        }

        RenderView::render('admin-panel',[
            'manageView' => 'Tiques/ver',
            'selectsData' => $selectsData
        ]);

        RenderView::render('admin-panel',
            [
                'manageView' => 'Tiques/'.$action
            ]
        );
    }

    public function showHome()
    {

        $tique = new Tique();
        $stats = $tique->getCreationStatsByUser($_SESSION['user']['id_usuario']);

        $totalTiques = 0;
        $meses = [];
        $data = [];

        foreach ($stats as $stat) {
            $totalTiques += $stat['cantidad'];
            $meses[] = $stat['mes'];
            $data[] = $stat['cantidad'];
        }

        $tiqueStats = ['totalTiques' => $totalTiques, 'meses' => $meses, 'data' => $data];

        RenderView::render('admin-panel',[
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