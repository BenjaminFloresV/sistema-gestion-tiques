<?php

namespace SistemaTique\Helpers;

use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

class Helpers
{
    public static function showPre( mixed $data )
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    public static function generateRandomPassword()
    {
        $generator = new ComputerPasswordGenerator();
        $generator
            ->setOptionValue(ComputerPasswordGenerator::OPTION_UPPER_CASE, true)
            ->setOptionValue(ComputerPasswordGenerator::OPTION_LOWER_CASE, true)
            ->setOptionValue(ComputerPasswordGenerator::OPTION_NUMBERS, true)
            ->setOptionValue(ComputerPasswordGenerator::OPTION_SYMBOLS, false)
            ->setOptionValue(ComputerPasswordGenerator::OPTION_LENGTH, 12);

        return $generator->generatePassword();
    }

    public static function userExist( string $user ): bool
    {
        return isset( $_SESSION[$user] );
    }

    public static function fixBadUnicode($str) {
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})/mi", fn($m) => chr(hexdec($m[1])).chr(hexdec($m[2])).chr(hexdec($m[3])).chr(hexdec($m[4])), $str);
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})/mi", fn($m) => chr(hexdec($m[1])).chr(hexdec($m[2])).chr(hexdec($m[3])), $str);
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})/mi", fn($m) => chr(hexdec($m[1])).chr(hexdec($m[2])), $str);
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})/i", fn($m) => chr(hexdec($m[1])), $str);
        return $str;
    }
}