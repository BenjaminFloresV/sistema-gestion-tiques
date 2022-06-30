<?php

namespace SistemaTique\Middleware;

use JetBrains\PhpStorm\NoReturn;

class RenderView
{

    #[NoReturn] public static function render($view = '')
    {
        require_once __DIR__.'/../Mvc/Views/User/layouts/header.phtml';
        require_once __DIR__.'/../Mvc/Views/User/'.$view.'.phtml';
        require_once __DIR__.'/../Mvc/Views/User/layouts/footer.phtml';
        exit();
    }


}