<?php

namespace SistemaTique\Mvc\Controllers;

use SistemaTique\Helpers\FormVerifier;
use SistemaTique\Helpers\Helpers;
use SistemaTique\Mvc\Models\Area;
use SistemaTique\Mvc\Models\Criticidad;

class AreaController
{
    public function create()
    {
        Helpers::isAdmin(2);

        if( isset($_POST) && !empty($_POST) ) {
            $validData = FormVerifier::verifyInputs($_POST);

            if( $validData && FormVerifier::verifyKeys(['nombre'], $_POST) ){

                $area = new  Area();
                $area->setNombre($_POST['nombre']);

                $create = $area->create();

                if( $create ) {
                    $_SESSION['success-message'] = 'Área creda con éxito';
                }else{
                    $_SESSION['success-message'] = 'No se pudo crear el área, asegúrese de que no exista';
                }

            }else {
                $_SESSION['error-message'] = 'No se pudo crear el área, faltan campos';
            }
        }else {
            $_SESSION['error-message'] = 'Los datos enviados no son válidos';
        }

        header('Location:'.BASE_URL.'/admin-home/areas/');
        exit();
    }

    public function update()
    {
        Helpers::isAdmin(2);
        if( isset($_POST) && !empty($_POST) ) {

            $validData = FormVerifier::verifyInputs($_POST);

            if( $validData && FormVerifier::verifyKeys(['id_area', 'nombre'],$_POST) ) {

                $area = new Area();
                $area->setId_area($_POST['id_area']);
                $area->setNombre($_POST['nombre']);

                $update = $area->update();

                if( $update ) {
                    $_SESSION['success-message'] = 'Area actualizada con éxito';
                }else {
                    $_SESSION['error-message'] = 'No se pudo actualizar el area';
                }
            }else{
                $_SESSION['error-message'] = 'No se pudo actualizar, faltan campos por rellenar';
            }

        }else {
            $_SESSION['error-message'] = 'Datos enviados no válidos';
        }

        header("Location:".BASE_URL.'/admin-home/areas/');
        exit();
    }

    public function delete( int $id )
    {
        Helpers::isAdmin(2);
        if( isset($id) ){

            $area = new Area();
            $area->setId_area($id);
            $isUsed = $area->idInUse();

            if( !$isUsed ) {

                $delete = $area->delete();

                if( $delete ) {
                    $_SESSION['success-message'] = 'El área fue eliminada con éxito';
                }else {
                    $_SESSION['error-message'] = "El área con id: $id no existe";
                }

            }else {
                $_SESSION['error-message'] = 'El area está asociada a algún tique o usuario no puede ser eliminada';
            }

        }else {
            $_SESSION['error-message'] = 'Id de área inválido.';
        }

        header("Location:".BASE_URL.'/admin-home/areas/');
        exit();
    }
}