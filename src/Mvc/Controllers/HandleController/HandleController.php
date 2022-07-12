<?php

namespace SistemaTique\Mvc\Controllers\HandleController;

use SistemaTique\Mvc\Controllers\Roles\EjecutivoAreaController;
use SistemaTique\Mvc\Controllers\Roles\EjecutivoMesaController;
use SistemaTique\Mvc\Controllers\Roles\JefeMesaController;

class HandleController
{
    public function handleTique()
    {
        if( isset($_SESSION['user']) ){

            switch ($_SESSION['user']['id_tipo']){
                case 1:
                    $controller = new EjecutivoMesaController();
                    break;
                case 2:
                    $controller = new JefeMesaController();
                    break;
                case 3:
                    $controller = new EjecutivoAreaController();
                    break;
                default:
                    break;
            }

            $controller->manageTiques();
        }else {
            header('Location:'.BASE_URL);
            exit();
        }
    }

    public function manageHome()
    {
        if( isset($_SESSION['user']) ){

            switch ($_SESSION['user']['id_tipo']){
                case 1:
                    $controller = new EjecutivoMesaController();
                    break;
                case 2:
                    $controller = new JefeMesaController();
                    break;
                case 3:
                    $controller = new EjecutivoAreaController();
                    break;
                default:
                    break;
            }

            $controller->showHome();
        }else {
            header('Location:'.BASE_URL);
            exit();
        }
    }


    public function handleProfile()
    {
        if( isset($_SESSION['user']) ) {


            switch ($_SESSION['user']['id_tipo']){
                case 1:
                    $controller = new EjecutivoMesaController();
                    break;
                case 2:
                    $controller = new JefeMesaController();
                    break;
                case 3:
                    $controller = new EjecutivoAreaController();
                    break;
                default:
                    break;
            }

            $controller->showProfile();


        }else {
            header('Location:'.BASE_URL);
            exit();
        }
    }
}
