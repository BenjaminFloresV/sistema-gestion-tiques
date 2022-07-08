<?php

namespace SistemaTique\Helpers;


use Exception;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

class Helpers
{
    public static function showPre(mixed $data)
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

    public static function userExist(string $user): bool
    {
        return isset($_SESSION[$user]);
    }

    public static function fixBadUnicode($str)
    {
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})/mi", fn($m) => chr(hexdec($m[1])) . chr(hexdec($m[2])) . chr(hexdec($m[3])) . chr(hexdec($m[4])), $str);
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})/mi", fn($m) => chr(hexdec($m[1])) . chr(hexdec($m[2])) . chr(hexdec($m[3])), $str);
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})\\\\u00([0-9a-f]{2})/mi", fn($m) => chr(hexdec($m[1])) . chr(hexdec($m[2])), $str);
        $str = preg_replace_callback("/\\\\u00([0-9a-f]{2})/i", fn($m) => chr(hexdec($m[1])), $str);
        return $str;
    }

    //  This method verify the URL endpoint in some Adminsitrator Views
    // to determinates the php file that needs to be loaded from Admin's Views folder.
    public static function verifyAction($action): string
    {
        $allowedActions = ['editar', 'crear', 'ver', 'borrar'];
        if (!in_array($action, $allowedActions)) $action = 'ver';

        return $action;
    }


    // This method verify if a specific Views needs categories data or entities
    public static function verifySelects($action): bool
    {
        return match ($action) {
            'editar', 'crear' => true,
            default => false,
        };
    }


    // This method returns arrays within array with different entities's data that is necessary for Admin actions( insert, update, etc )
    public static function retrieveSelectsData(array $objects): bool|array
    {

        $objectsData = array();
        $result = false;
        try {

            foreach ($objects as $object) {


                $name = $object[2];
                $method = $object[1];
                $objectsData += [$name => $object[0]->$method()];

            }

            $result = $objectsData;

        } catch (Exception $exception) {

        }

        return $result;

    }



    // This method is used to get object data if we need to update data or show all the data of certain entity.
    // options = id : int, join : bool, getObjectCategories: bool
    // object is an array: [ object, method, nameOfResults ]
    public static function retrieveObjectData(string $action, array $object, array $options = null): array|null
    {
        $result = null;

        if ($action == 'ver') {
            $method = $object[1];
            $result = $object[0]->$method();

        }

        return $result;

    }

    public static function isAdmin(int $userType):void
    {
        if( !isset($_SESSION['user']) && $_SESSION['user'] === $userType){
            header('Location:'.BASE_URL.'/admin-home');
            exit();
        }
    }

    public static function removeSession( string $name )
    {
        if(isset($_SESSION[$name])){
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
    }

}