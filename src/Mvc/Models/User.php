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
        $this->log = NewLogger::newLogger('USER_MODEL');
        $this->log->debug('Class has been instancied.');
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

    /**
     * @throws Exception
     */
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
            throw new Exception($exception);
        }

        return $result;
    }


    public function getAll(): array|bool
    {
        $result = false;
        try {

            $sql = "SELECT u.id_usuario AS id, tu.nombre AS tipoUsuario, a.nombre AS area, u.login_habilitado AS habilitado, u.nombre, u.apellido, u.telefono";
            $sql .= ",UNIX_TIMESTAMP(u.fecha_nacimiento) AS fechaNacimiento, u.correo, u.rut FROM usuario u";
            $sql .= " INNER JOIN tipo_usuario tu ON u.id_tipo=tu.id_tipo";
            $sql .= " INNER JOIN area a ON u.id_area=a.id_area";
            $st = $this->conn->prepare($sql);
            $query = $st->execute();

            if( $query ) {
                $this->log->info('Users data has been collected successfully.');
                $result = $st->fetchAll(PDO::FETCH_ASSOC);
                $this->log->info('This is the current data', array('data'=> $result));
            }

        } catch (Exception $exception) {
            $this->log->debug('Something went wrong while trying to collect Users data', array('exception' => $exception));
        }
        return $result;
    }









}