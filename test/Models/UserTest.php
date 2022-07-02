<?php

require_once __DIR__.'/../../config.php';

use \PHPUnit\Framework\TestCase;
use SistemaTique\Mvc\Models\User;





class UserTest extends TestCase
{

    public function getAll()
    {
        // Setup
        $user = new User();

        // Action
        $users = $user->getAll();

        // Assertions
        $this->assertEquals("array", gettype($users));

    }


    public function getUserTypes()
    {
        $logger = \SistemaTique\Helpers\NewLogger::newLogger('USER_TEST');
        $user = new User();
        $userTypes = $user->getUserTypes();

        $this->assertEquals("array", gettype($userTypes));
    }


    public function update()
    {
        $user = new User();
        $user->setId(1);
        $fakeData = array(
            'nombre' => 'Hasiom',
            'apellido' => 'Sorevir',
            'telefono' => '+56967977241',
            'login_habilitado' => 1,
            'correo' => 'hasiom@sorevir.com',
            'rut' => '20217260-1',
            'fecha_nacimiento' => '2022-06-02',

        );
        $update = $user->update($fakeData);

        $this->assertEquals(true, $update);

    }

    /** @test  */
    public function getOneByRut()
    {
        $user = new User();
        $user->setRut('20217260-1');
        $userData = $user->getOneByRut();

        $this->assertEquals('object', gettype($userData));
    }
}