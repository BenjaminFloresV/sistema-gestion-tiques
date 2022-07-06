<?php

use Pecee\SimpleRouter\SimpleRouter;


SimpleRouter::get('/', [\SistemaTique\Mvc\Controllers\UserController::class, 'index']);


SimpleRouter::get('/admins-login', [\SistemaTique\Mvc\Controllers\UserController::class, 'login']);
SimpleRouter::post('/admins-login', [\SistemaTique\Mvc\Controllers\UserController::class, 'loginVerify']);
SimpleRouter::get('/admin-home', [\SistemaTique\Mvc\Controllers\UserController::class, 'adminHome']);

SimpleRouter::get('/admin-home/usuarios/{action?}', [\SistemaTique\Mvc\Controllers\JefeMesaController::class, 'manageUsuarios'])
;