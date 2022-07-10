<?php

namespace SistemaTique\Mvc\Controllers\Roles;

use SistemaTique\Helpers\FormVerifier;
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
        Helpers::isAdmin(2);
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
        Helpers::isAdmin(2);
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

        Helpers::isAdmin(2);
        $action = Helpers::verifyAction($action);

        $data = Helpers::retrieveObjectData( $action, [new Area(), 'getAll'] );

        RenderView::render('admin-panel',
            [
                'manageView' => 'Areas/'.$action,
                'data' => $data
            ]
        );

    }

    public function manageTiposTique( string $action = null ): void
    {
        Helpers::isAdmin(2);
        $action = Helpers::verifyAction($action);

        $data = Helpers::retrieveObjectData($action, [new Tique(), 'getTiqueTypes']);

        RenderView::render('admin-panel',
            [
                'manageView' => 'TiposTique/'.$action,
                'data' => $data
            ]
        );


    }

    public function manageTiques( string $action = null ): void
    {
        Helpers::isAdmin(2);
        $action = Helpers::verifyAction($action);
        if( isset($_GET) && !empty($_GET) && FormVerifier::verifyPossibleKeys(['fecha', 'id_criticidad', 'id_tipo', 'id_area', 'rut_usuario_crea', 'rut_usuario_cierra'], $_GET) && FormVerifier::verifyInputs($_GET)) {

            $tique = new Tique();
            $data = $tique->getAllFiltered($_GET);


        }else {
            $data = Helpers::retrieveObjectData($action, [new Tique(), 'getAll']);
        }


        $selectsData = Helpers::retrieveSelectsData(
            [
                [new Tique(), 'getTiqueTypes', 'tiposTique'],
                [new Area(), 'getAll', 'tipoAreas'],
                [new Criticidad(), 'getAll', 'criticidades']
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


}