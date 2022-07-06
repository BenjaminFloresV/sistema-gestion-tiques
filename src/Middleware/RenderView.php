<?php

namespace SistemaTique\Middleware;

use JetBrains\PhpStorm\NoReturn;

class RenderView
{

    #[NoReturn] public static function render($view = '', array $data = null)
    {
        $rolId = $_SESSION['user']['id_tipo'];
        if( isset($data['manageView']) ) $manageView = $data['manageView'];
        if( isset($data['selectsData']) ) $selectsData = $data['selectsData'];
        if( isset($data['data']) ) $data = $data['data'];

        require_once __DIR__.'/../Mvc/Views/User/layouts/header.phtml';
        require_once __DIR__.'/../Mvc/Views/User/'.$view.'.phtml';
        require_once __DIR__.'/../Mvc/Views/User/layouts/footer.phtml';
        exit();
    }


}