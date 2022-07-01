<?php

namespace SistemaTique\API;

use PHPUnit\Exception;
use SistemaTique\API\BaseController\BaseController;
use SistemaTique\Mvc\Models\User;

class UserController extends BaseController
{
    public function get( $id = null)
    {
        if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
            try {
                if( !isset($id) ) {
                    $userModel = new User();
                    $responseData = json_encode($userModel->getAll(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
                }
            } catch (Exception $exception ) {
                $strErrorDesc = $exception->getMessage(). 'Something went wrong!! Please contact support';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }

        }else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if( !isset($strErrorHeader) ) {
            $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
        }else {
            $this->sendOutput(json_encode([ 'error' => $strErrorDesc ]), [$strErrorHeader]);
        }

        exit();
    }
}