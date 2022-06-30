<?php

namespace SistemaTique\Mvc\Models;

use PDO;
use Psr\Log\LoggerInterface;
use SistemaTique\Database\Connection;
use SistemaTique\Helpers\NewLogger;
use Exception;

class User
{

    private int $id_usario;
    private int $id_tipo;
    private int $id_area;
    private bool $login_habilitado;
    private string $nombre;
    private string $apellido;
    private string $telefono;
    private string $fecha_nacimiento;
    private string $correo;
    private string $rut;
    private string $password;
    private string $expiration_password;

    private LoggerInterface $log;
    private PDO|bool $conn;



    public function __construct()
    {
        $this->log = NewLogger::newLogger('USER_MODEL', 'FirePHPHandler');
        $this->log->info('Class has been instancied.');
        $this->conn = Connection::dbConnection();

    }

    public function setRut( string $rut )
    {
        $this->rut = $rut;
    }

    public function verifyConnection(): bool
    {
        return $this->conn;
    }

    // This method gets user data using rut by default
    public function getOneByRut()
    {
        $result = false;

        try {
            $this->log->info('Trying to get user data');

            $sql = "SELECT *, UNIX_TIMESTAMP(fecha_nacimiento) AS fechaNacimiento  FROM usuario WHERE rut=:rut";
            $st = $this->conn->prepare($sql);

            $st->bindParam(':rut',$this->rut,PDO::PARAM_STR);
            $query = $st->execute();

            if( $query ) {
                $this->log->info('User data has been collected successfully.');
                $result = $st->fetchObject();
            }


        } catch ( Exception $exception ) {
            $this->log->error('Somehting wrong while trying to get User data', array('exception', $exception));
        }

        return $result;
    }







}