<?php

namespace SistemaTique\Mvc\Controllers;

use SistemaTique\Helpers\Helpers;
use SistemaTique\Helpers\NewLogger;
use SistemaTique\Mvc\Models\User;
use SistemaTique\Middleware\RenderView;

class UserController
{

    public function index(): void
    {
        echo 'hola esta es la pagina principal';

    }

    public function login()
    {
        if( !Helpers::userExist('user') ) {
            RenderView::render('login');
        }else {
            header("Location:".BASE_URL."/admin-home");
        }


    }

    public function adminHome()
    {
        $log = NewLogger::newLogger('USER_CONTROLLER', 'FirePHPHandler');

        if( Helpers::userExist('user') ) {
            try {

                RenderView::render('admin-panel');

            } catch (\Exception $exception) {
                $log->error('Something went wrong in adminHome Method', array('exception' => $exception));
            }

        }else {
            echo 'No es un admin';
        }

    }


    public function loginVerify()
    {
        if( isset($_POST) && !Helpers::userExist('user') ) {

            $user = new User();

            $user->setRut( $_POST['rut'] );
            $userData = $user->getOneByRut();

            if( password_verify( $_POST['password'], $userData->password  ) ) {

                $userSecureData =  array(
                    'id_usuario' => $userData->id_usuario,
                    'nombre' => $userData->nombre,
                    'rut' => $userData->rut,
                    'id_tipo' => $userData->id_tipo
                );

                $_SESSION['user'] = $userSecureData;
                sleep(1);
                header("Location:".BASE_URL.'/admin-home');
                exit();
            }else {
                echo 'no se logueo';
            }

        }

        header("Location:".BASE_URL."/admins-login");
        exit();
    }



}