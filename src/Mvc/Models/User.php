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


    public function setPassword( string $password )
    {
        $this->password = $password;
    }

    public function setPasswordExpiration( string $passwordExpiration )
    {
        $this->expiration_password = $passwordExpiration;
    }

    public function setLoginAccess( bool $hasAccess )
    {
        $this->login_habilitado = $hasAccess;
    }

    public function __construct()
    {
        $this->log = NewLogger::newLogger('USER_MODEL');
        $this->log->debug('Class has been instancied.');
        $this->conn = Connection::dbConnection();

    }

    public function storeFormValues( array $data ): bool
    {
        $result = false;
        try {
            $this->log->debug('Trying to store form values');
            if( isset($data['rut'])) $this->rut = (string) $data['rut'];
            if( isset($data['correo'])) $this->correo = (string) $data['correo'];
            if( isset($data['nombre'])) $this->nombre = (string) $data['nombre'];
            if( isset($data['apellido'])) $this->apellido = (string) $data['apellido'];
            if( isset($data['id_tipo'])) $this->id_tipo = (int) $data['id_tipo'];
            if( isset($data['id_area'])) $this->id_area = (int) $data['id_area'];

            $result = true;
        } catch ( Exception $exception ) {
            $this->log->error('Something went wrong while storing form values', array('exception' => $exception));
        }

        return $result;
    }

    public function setId( int $id )
    {
        $this->id_usario = $id;
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
            $wantedData = array(
                'id_usuario', 'id_tipo', 'id_area', 'login_habilitado', 'nombre',
                'apellido', 'telefono','correo', 'rut', 'expiration_password', 'password'
            );
            $sql = "SELECT ".implode(",", $wantedData).", UNIX_TIMESTAMP(fecha_nacimiento) AS fechaNacimiento ";
            $sql .= "FROM usuario WHERE rut=:rut";
            $st = $this->conn->prepare($sql);

            $st->bindParam(':rut',$this->rut,PDO::PARAM_STR);
            $query = $st->execute();


            if( $query ) {
                if( $st->rowCount() !== 0 ) {
                    $this->log->info('User data has been collected successfully.');
                    $result = $st->fetchObject();
                }
            }


        } catch ( Exception $exception ) {
            $this->log->error('Somehting wrong while trying to get User data', array('exception', $exception));
        }

        $st->closeCursor();

        return $result;
    }


    public function getAll(): array|bool
    {
        $result = false;
        try {

            $sql = "SELECT u.id_usuario AS id_usuario,u.id_tipo, tu.nombre AS tipoUsuario, a.nombre AS area,u.id_area, u.login_habilitado AS habilitado, u.nombre, u.apellido, u.telefono";
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

            $st->closeCursor();

        } catch (Exception $exception) {
            $this->log->debug('Something went wrong while trying to collect Users data', array('exception' => $exception));
        }
        return $result;
    }

    public function getUserTypes(): array|false
    {
        $result = false;
        try {
            $sql = "SELECT * FROM tipo_usuario";
            $st = $this->conn->prepare($sql);
            $query = $st->execute();


            if( $query ) {
                $this->log->debug('User Types data collected successfully');
                $result = $st->fetchAll(PDO::FETCH_ASSOC);
                $this->log->debug('Data', array('data' => $result));
            }

        } catch ( Exception $exception ) {
            $this->log->debug('Something went wrong while trying to collect User type data', array('exception' => $exception));
        }
        $st->closeCursor();
        return $result;
    }

    public function create(): bool
    {
        $result = false;
        try {
            $sql = "INSERT INTO usuario (id_usuario, id_tipo, id_area, login_habilitado, nombre, apellido, telefono, fecha_nacimiento, correo, rut, password, expiration_password) ";
            $sql .= "VALUES(:id_usuario, :id_tipo, :id_area, :login_habilitado, :nombre, :apellido, :telefono, :fecha_nacimiento, :correo, :rut, :password, :expiration_password)";
            $st = $this->conn->prepare($sql);
            $st->bindValue(':id_usuario', null, PDO::PARAM_NULL);
            $st->bindValue(':id_tipo', $this->id_tipo, PDO::PARAM_INT);
            $st->bindValue(':id_area', $this->id_area, PDO::PARAM_INT);
            $st->bindValue(':login_habilitado', $this->login_habilitado, PDO::PARAM_BOOL);
            $st->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $st->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $st->bindValue(':telefono', null, PDO::PARAM_NULL);
            $st->bindValue(':fecha_nacimiento', null, PDO::PARAM_NULL);
            $st->bindValue(':rut', $this->rut, PDO::PARAM_STR);
            $st->bindValue(':password', $this->password, PDO::PARAM_STR);
            $st->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $st->bindValue('expiration_password', $this->expiration_password, PDO::PARAM_STR);

            $query = $st->execute();

            if( $query ) {
                $this->log->debug('User has been created successfully');
                $result = true;
            }else {
                $this->log->warning('Could not create a new User');
            }

            $st->closeCursor();

        } catch (Exception $exception) {
            $this->log->error('Something went wrong while trying to insert an new User', array('exception'=>$exception));
        }

        return $result;

    }



    public function update( array $options = null):bool
    {
        $result = false;
        $availableVarCharOptions = array('nombre', 'apellido', 'telefono', 'correo', 'rut', 'fecha_nacimiento');
        $availableIntOptions = array('id_area', 'id_tipo','login_habilitado');

        try {
            $this->log->debug('Trying to update a User');
            $toBeUpdate = [];
            if( isset($options['nombre']) ) $toBeUpdate[] = "nombre=:nombre";
            if( isset($options['apellido'])) $toBeUpdate[] = "apellido=:apellido";
            if( isset($options['telefono']) ) $toBeUpdate[] = "telefono=:telefono";
            if( isset($options['fecha_nacimiento'])) $toBeUpdate[] = "fecha_nacimiento=:fecha_nacimiento";
            if( isset($options['id_area']) ) $toBeUpdate[] = "id_area=:id_area";
            if( isset($options['id_tipo']) ) $toBeUpdate[] = "id_tipo=:id_tipo";
            if( isset($options['login_habilitado'])) $toBeUpdate[] = "login_habilitado=:login_habilitado";
            if( isset($options['rut']) ) $toBeUpdate[] = "rut=:rut";
            if( isset($options['correo'])) $toBeUpdate[] = "correo=:correo";

            $sql = "UPDATE usuario SET ".implode(',',$toBeUpdate)." WHERE id_usuario=:id_usuario";
            $st = $this->conn->prepare($sql);

            foreach ($availableVarCharOptions as $posibleOption){
                if( isset($options[$posibleOption]) ) $st->bindValue(":".$posibleOption, $options[$posibleOption],PDO::PARAM_STR);
            }
            foreach ($availableIntOptions as $posibleOption){
                if( isset($options[$posibleOption]) ) $st->bindValue(":".$posibleOption, $options[$posibleOption],PDO::PARAM_INT);
            }
            $st->bindValue(':id_usuario', $this->id_usario, PDO::PARAM_INT);

            $query = $st->execute();

            if( $query ) {
                $this->log->debug('User updated successfully');
                $result = true;
            }else {
                $this->log->warning('User could not be updated');
            }


        } catch (Exception $exception) {
            $this->log->error('Something went wrong while trying to update an user', array('exception'=> $exception));
        }

        return $result;
    }

    public function changeSystemAccess( bool $allow )
    {
        $result = false;
        try{
            $this->log->debug('Trying to update user system access');
            $sql = "UPDATE usuario SET login_habilitado=:login_habilitado WHERE rut=:rut";

            $st = $this->conn->prepare($sql);

            $st->bindValue(':login_habilitado', $allow, PDO::PARAM_BOOL);
            $st->bindValue(':rut', $this->rut, PDO::PARAM_STR);

            $query = $st->execute();

            if( $query ) {
                if( $st->rowCount() !== 0 ){
                    $result = true;
                    $this->log->debug('User system access status changed successfully');
                }
            }else {
                $this->log->debug('Failed to update User system access status');
            }

            $st->closeCursor();

        }catch ( Exception $exception ){
            $this->log->error('Something went wrong while trying to change system access');
        }

        return $result;
    }


    public function resetPassword()
    {
        $result = false;
        try{
            $this->log->debug('Trying to update user system access');
            $sql = "UPDATE usuario SET password=:password, expiration_password=:expiration_password WHERE rut=:rut";

            $st = $this->conn->prepare($sql);

            $st->bindValue(':rut', $this->rut, PDO::PARAM_STR);
            $st->bindValue(':password', $this->password, PDO::PARAM_STR);
            $st->bindValue(':expiration_password', $this->expiration_password, PDO::PARAM_STR);

            $query = $st->execute();

            if( $query ) {
                if( $st->rowCount() !== 0 ){
                    $result = true;
                    $this->log->debug('User system access status changed successfully');
                }
            }else {
                $this->log->debug('Failed to update User system access status');
            }

            $st->closeCursor();

        }catch ( Exception $exception ){
            $this->log->error('Something went wrong while trying to change system access');
        }

        return $result;
    }



}