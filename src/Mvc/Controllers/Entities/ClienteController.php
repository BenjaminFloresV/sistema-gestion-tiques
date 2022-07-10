<?php

namespace SistemaTique\Mvc\Controllers\Entities;

use SistemaTique\Helpers\FormVerifier;
use SistemaTique\Helpers\Helpers;
use SistemaTique\Mvc\Models\Client;

class ClienteController
{
    public function verifyClient()
    {
        Helpers::isAdmin(1);
        if( isset($_POST) && !empty($_POST) && FormVerifier::verifyKeys(['rut'], $_POST) ) {
            $validData =  FormVerifier::verifyInputs($_POST);

            if( $validData ) {
                $client = new Client();
                $client->setRutCliente($_POST['rut']);

                $clientInfo = $client->getClientInfo();

                if( $clientInfo ) {
                    $_SESSION['clientInfo'] = $clientInfo;

                }else {
                    $_SESSION['clientInfo'] = [];
                    $_SESSION['error-message'] = 'El cliente con rut '.$_POST['rut'].' no existe';
                }

            }else {
                $_SESSION['error-message'] = 'Los datos enviados no son válidos.';
            }
        }else {
            $_SESSION['error-message'] = 'Los datos enviados no son válidos o faltan campos.';
        }

        header('Location:'.BASE_URL.'/admin-home/tiques/');
        exit();
    }
}