<?php

require_once __DIR__.'/../../config.php';

use \PHPUnit\Framework\TestCase;
use SistemaTique\Mvc\Models\User;





class UserTest extends TestCase
{
    /** @test  */
    public function getAll()
    {
        // Setup
        $user = new User();

        // Action
        $users = $user->getAll();

        // Assertions
        $this->assertEquals("array", gettype($users));

    }
}