<?php

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;


SimpleRouter::get('/', [\SistemaTique\Mvc\Controllers\UserController::class, 'index']);


SimpleRouter::get('/admins-login', [\SistemaTique\Mvc\Controllers\UserController::class, 'login']);
SimpleRouter::get('/admin-home/cerrar', [\SistemaTique\Mvc\Controllers\UserController::class, 'logout']);
SimpleRouter::post('/admins-login', [\SistemaTique\Mvc\Controllers\UserController::class, 'loginVerify']);
SimpleRouter::get('/admin-home', [\SistemaTique\Mvc\Controllers\UserController::class, 'adminHome']);

// Usuarios
SimpleRouter::get('/admin-home/usuarios/{action?}', [\SistemaTique\Mvc\Controllers\JefeMesaController::class, 'manageUsuarios']);


SimpleRouter::post('/usuarios/crear',[\SistemaTique\Mvc\Controllers\UserController::class, 'create']);
SimpleRouter::get('/usuarios/deshabilitar/{rut}', [\SistemaTique\Mvc\Controllers\UserController::class, 'restrictAccess']);
SimpleRouter::get('/usuarios/habilitar/{rut}',[\SistemaTique\Mvc\Controllers\UserController::class, 'allowAccess']);
SimpleRouter::get('/usuarios/resetear/{rut}',[\SistemaTique\Mvc\Controllers\UserController::class, 'resetPassword']);

//Criticidad
SimpleRouter::get('/admin-home/criticidad/{action?}', [\SistemaTique\Mvc\Controllers\JefeMesaController::class, 'manageCriticidad']);

SimpleRouter::get('/criticidad/eliminar/{id}', [\SistemaTique\Mvc\Controllers\CriticidadController::class, 'delete']);
SimpleRouter::post('/criticidad/actualizar/', [\SistemaTique\Mvc\Controllers\CriticidadController::class, 'update']);
SimpleRouter::post('/criticidad/crear', [\SistemaTique\Mvc\Controllers\CriticidadController::class, 'create']);


//Areas
SimpleRouter::get('/admin-home/areas/{action?}',[\SistemaTique\Mvc\Controllers\JefeMesaController::class, 'manageAreas']);

SimpleRouter::post('/areas/crear/', [\SistemaTique\Mvc\Controllers\AreaController::class, 'create']);
SimpleRouter::post('/areas/actualizar/', [\SistemaTique\Mvc\Controllers\AreaController::class, 'update']);
SimpleRouter::get('/areas/eliminar/{id}', [\SistemaTique\Mvc\Controllers\AreaController::class, 'delete']);


//Tipo Tique
SimpleRouter::get('/admin-home/tipos-tique/{action?}', [\SistemaTique\Mvc\Controllers\JefeMesaController::class, 'manageTiposTique']);

SimpleRouter::post('/tipos-tique/crear', [\SistemaTique\Mvc\Controllers\TiqueController::class, 'createTipo']);
SimpleRouter::post('/tipos-tique/actualizar', [\SistemaTique\Mvc\Controllers\TiqueController::class, 'updateTipo']);
SimpleRouter::get('/tipos-tique/eliminar/{id}', [\SistemaTique\Mvc\Controllers\TiqueController::class, 'deleteTipo']);


SimpleRouter::error(function (Request $request, \Exception $exception){

    switch ($exception->getCode()){
        // Page not found
        case 404:
            response()->redirect('/');
            break;
        // Forbidden
        case 403:
            response()->redirect('/');;
    }
});