<?php

namespace SistemaTique\Mvc\Controllers;

use SistemaTique\Helpers\FormVerifier;
use SistemaTique\Helpers\Helpers;
use SistemaTique\Mvc\Models\Criticidad;

class CriticidadController
{
    public function create(): void
    {
        Helpers::isAdmin(2);
        if( isset($_POST) && !empty($_POST) ){
            $validData = FormVerifier::verifyInputs($_POST);
            if( $validData && FormVerifier::verifyKeys(['nombre', 'valor'], $_POST) ){

                $newCriticidd = new Criticidad();
                $newCriticidd->setValor($_POST['valor']);
                $newCriticidd->setNombre($_POST['nombre']);

                $create = $newCriticidd->create();

                if($create) {
                    $_SESSION['success-message'] = 'Criticidad creada con éxito';
                }else {
                    $_SESSION['error-message'] = 'No se pudo crear la criticidad, problemas con el servidor';
                }

            }else{
                $_SESSION['error-message'] = 'Datos incorrectos, ingrese valores permitidos';
            }
        }else{
            $_SESSION['error-message'] = 'No se han enviado los valores necesarios para crear una Criticidad';
        }


        header('Location:'.BASE_URL.'/admin-home/criticidad/');
        exit();
    }


    public function delete( int $id = null ):void
    {
        Helpers::isAdmin(2);

        if( isset($id) ){

            $criticidad = new Criticidad();
            $criticidad->setIdCriticidad($id);
            $isUsed = $criticidad->idInUse();

            if( !$isUsed ) {

                $delete = $criticidad->delete();

                if( $delete ) {
                    $_SESSION['success-message'] = 'La criticidad fue eliminada con éxito';
                }else {
                    $_SESSION['error-message'] = "La criticidad con id: $id no existe";
                }

            }else {
                $_SESSION['error-message'] = 'La criticidad está asociada a algún tique, no puede ser eliminada';
            }

        }else {
            $_SESSION['error-message'] = 'Id de criticidad inválido.';
        }

        header("Location:".BASE_URL.'/admin-home/criticidad/');
        exit();

    }

    public function update()
    {
        Helpers::isAdmin(2);
        if( isset($_POST) && !empty($_POST) ) {

            $validData = FormVerifier::verifyInputs($_POST);

            if( $validData && FormVerifier::verifyKeys(['id_criticidad', 'nombre', 'valor'],$_POST) ) {

                $criticidad = new Criticidad();
                $criticidad->setIdCriticidad($_POST['id_criticidad']);
                $criticidad->setNombre($_POST['nombre']);
                $criticidad->setValor($_POST['valor']);

                $update = $criticidad->update();

                if( $update ) {
                    $_SESSION['success-message'] = 'Criticidad actualizada con éxito';
                }else {
                    $_SESSION['error-message'] = 'No se pudo actualizar la criticidad';
                }
            }else{
                $_SESSION['error-message'] = 'No se pudo actualizar, faltan campos por rellenar';
            }

        }else {
            $_SESSION['error-message'] = 'Datos enviados no válidos';
        }

        header("Location:".BASE_URL.'/admin-home/criticidad/');
        exit();
    }
}