<?php

namespace SistemaTique\Mvc\Controllers;

use SistemaTique\Helpers\FormVerifier;
use SistemaTique\Helpers\Helpers;
use SistemaTique\Mvc\Models\Criticidad;
use SistemaTique\Mvc\Models\Tique;

class TiqueController
{

    public function create()
    {

    }

    public function update()
    {

    }


    public function createTipo()
    {
        Helpers::isAdmin(2);
        if( isset($_POST) && !empty($_POST) ){
           $validData = FormVerifier::verifyInputs($_POST);

           if( $validData && FormVerifier::verifyKeys(['nombre'], $_POST)){
               $tique = new Tique();
               $tique->setNombreTipoTique($_POST['nombre']);
               $createNewTipoTique = $tique->createTipo();

               if( $createNewTipoTique ){
                   $_SESSION['success-message'] = 'Tipo de tique creado con éxito';
               }else{
                   $_SESSION['error-message'] = 'El tipo de tique ya existe';
               }
           }else {
               $_SESSION['error-message'] = 'Campo no válido';
           }
        }else {
            $_SESSION['error-message'] = 'Faltan datos';
        }

        header('Location:'.BASE_URL.'/admin-home/tipos-tique/');
        exit();
    }

    public function updateTipo()
    {
        Helpers::isAdmin(2);
        if( isset($_POST) && !empty($_POST) ){
            $validData =  FormVerifier::verifyInputs($_POST);

            if( $validData && FormVerifier::verifyKeys(['nombre', 'id_tipo'], $_POST) ){
                $tique = new Tique();
                $tique->setIdTipoTique($_POST['id_tipo']);
                $tique->setNombreTipoTique($_POST['nombre']);

                $updateTipoTique = $tique->updateTipo();

                if( $updateTipoTique ) {
                    $_SESSION['success-message'] = 'Tipo de Tique actualizado con éxito';
                }else {
                    $_SESSION['error-message'] = 'No se pudo actualizar el tipo de Tique';
                }
            }else {
                $_SESSION['error-message'] = 'Los campos enviados son inválidos';
            }
        }else {
            $_SESSION['error-message'] = 'Faltan campos por rellenar';
        }

        header('Location:'.BASE_URL.'/admin-home/tipos-tique');
        exit();

    }

    public function deleteTipo( int $id = null )
    {
        Helpers::isAdmin(2);

        if( isset($id) ){

            $tique = new Tique();
            $tique->setIdTipoTique($id);
            $isUsed = $tique->idInUse();

            if( !$isUsed ) {

                $delete = $tique->deleteTipo();

                if( $delete ) {
                    $_SESSION['success-message'] = 'El tipo de tique fue eliminada con éxito';
                }else {
                    $_SESSION['error-message'] = "El tipo de tique con id: $id no existe";
                }

            }else {
                $_SESSION['error-message'] = 'EL tipo de tique está asociado a algún tique, no puede ser eliminado';
            }

        }else {
            $_SESSION['error-message'] = 'Id de tique inválido.';
        }

        header("Location:".BASE_URL.'/admin-home/tipos-tique/');
        exit();
    }
}