<?php

namespace SistemaTique\Helpers;

class Helpers
{
    public static function showPre( mixed $data )
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    public static function userExist( string $user ): bool
    {
        return isset( $_SESSION[$user] );
    }
}