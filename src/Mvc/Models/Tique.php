<?php

namespace SistemaTique\Mvc\Models;

use PDO;
use PHPUnit\Exception;
use Psr\Log\LoggerInterface;
use SistemaTique\Database\Connection;
use SistemaTique\Helpers\NewLogger;

class Tique
{
    private int $id_tique;
    private int $id_usuario_crea;
    private int $id_usuario_cierra;
    private int $id_estado;
    private string $rut_cliente;
    private int $id_area;
    private int $id_critiidad;
    private string $fecha_creacion;
    private string $detalle_problema;
    private string $detalle_servicio;
    private string $observacion;
    private PDO|bool $conn;
    private LoggerInterface $logger;

    private int $idTipoTique;
    private string $nombreTipoTique;

    public function __construct()
    {
        $this->logger = NewLogger::newLogger('TIQUE_MODEL');
        $this->conn = Connection::dbConnection();
    }

    public function setIdTique( int $id )
    {
        $this->id_tique = $id;
    }


    public function setIdTipoTique( int $id )
    {
        $this->idTipoTique = $id;
    }

    public function setNombreTipoTique( string $nombre ):void
    {
        $this->nombreTipoTique = $nombre;
    }

    public function storeFormValues( array $data ): bool
    {
        $availableIntFields = [
            'id_usuario_crea', 'id_usuario_cierra', 'id_estado', 'id_tipo', 'id_area', 'id_criticidad'
        ];
        $availableStrFields = [
            'rut_cliente', 'detalle_problema', 'detalle_servicio', 'observacion', 'fecha_creacion'
        ];
        $result = false;
        try {
            foreach ($availableIntFields as $field) {
                if( isset($data[$field]) ) $this->$field = (int) $data[$field];
            }

            foreach ( $availableStrFields as $field ) {
                if( isset($data[$field]) ) $this->$field = (string) $data[$field];
            }

            $result = true;
        } catch ( Exception $exception ){
            $this->logger->error('Could not store form values', array('exception' => $exception));
        }

        return $result;

    }

    public function create(): bool
    {
        $availableIntFields = ['id_usuario_crea', 'id_tipo', 'id_area', 'id_criticidad'];
        $availableStrFields = ['rut_cliente', 'detalle_problema', 'detalle_servicio', 'fecha_creacion'];
        $result = false;
        try {
            $this->logger->debug('Trying to create a new tique');
            $sql = "INSERT INTO tique (id_tique, id_usuario_crea, id_usuario_cierra, id_estado, rut_cliente, id_tipo,";
            $sql .= "id_area, id_criticidad, fecha_creacion, detalle_problema, detalle_servicio, observacion) ";
            $sql .= "VALUES(:id_tique, :id_usuario_crea, :id_usuario_cierra, :id_estado, :rut_cliente, :id_tipo,";
            $sql .= ":id_area, :id_criticidad, :fecha_creacion, :detalle_problema, :detalle_servicio, :observacion)";

            $st = $this->conn->prepare($sql);
            $st->bindValue(':id_tique', null, PDO::PARAM_NULL);
            $st->bindValue(':id_usuario_cierra', null, PDO::PARAM_NULL);
            $st->bindValue(':observacion', null, PDO::PARAM_NULL);
            $st->bindValue('id_estado', null, PDO::PARAM_NULL);
            foreach ( $availableIntFields as $field ){
                $st->bindValue(':'.$field, $this->$field, PDO::PARAM_INT);
            }
            foreach ( $availableStrFields as $field ){
                $st->bindValue(':'.$field, $this->$field, PDO::PARAM_STR);
            }

            $query = $st->execute();

            if( $query ){
                $this->logger->debug('New Tique has been created successfully');
                $result = true;
            }else {
                $this->logger->debug('Failed to create a new Tique');
            }

        } catch (Exception $exception){
            $this->logger->error('Something went wrong while trying to create a new tique');
        }

        return $result;

    }


    public function getTiqueTypes()
    {
        $result = false;
        try {
            $sql = "SELECT * FROM tipo_tique";
            $st = $this->conn->prepare($sql);

            $query = $st->execute();

            if( $query ) {
                $this->logger->debug('Tique types collectes successfully');
                $result = $st->fetchAll(PDO::FETCH_ASSOC);
            }

        } catch (\Exception $exception){
            $this->logger->error('Something went wrong while trying to collect Tique types', array('exception' => $exception));
        }

        return $result;
    }

    public function createTipo()
    {
        $result = false;
        try {
            $sql = "INSERT INTO tipo_tique(id_tipo, nombre) VALUES(:id_tipo, :nombre)";
            $st = $this->conn->prepare($sql);

            $st->bindValue(':id_tipo', null, PDO::PARAM_NULL);
            $st->bindValue(':nombre', $this->nombreTipoTique, PDO::PARAM_STR);

            $query = $st->execute();

            if( $query ) {
                $result = true;
                $this->logger->debug('Tipo Tique was created successfully');
            }

            $st->closeCursor();

        } catch (\Exception $exception){
            $this->logger->error('Something went wrong while trying to create a new Tique tipo', array('exception' => $exception));
        }

        return $result;
    }

    public function updateTipo()
    {
        $result = false;
        try {
            $sql = "UPDATE tipo_tique SET nombre=:nombre WHERE id_tipo=:id_tipo";
            $st = $this->conn->prepare($sql);

            $st->bindValue(':nombre', $this->nombreTipoTique, PDO::PARAM_STR);
            $st->bindValue(':id_tipo', $this->idTipoTique, PDO::PARAM_INT);

            $query = $st->execute();

            if( $query ) {
                $result = true;
                $this->logger->debug('Tipo Tique updated successfully');
            }else {
                $this->logger->debug('Cannot update Tipo Tique, contact support');
            }

            $st->closeCursor();

        } catch (\Exception $exception) {
            $this->logger->error('Something went wrong while trying to update tipo tique', array('exception' => $exception));
        }
        return $result;
    }

    public function deleteTipo()
    {
        $result = false;
        try {
            $sql = "DELETE FROM tipo_tique WHERE id_tipo=:id_tipo";
            $st = $this->conn->prepare($sql);

            $st->bindValue(':id_tipo', $this->idTipoTique, PDO::PARAM_INT);

            $query = $st->execute();
            if( $query ) {
                $affectedRows = $st->rowCount();
                if( $affectedRows !== 0 ) {
                    $result = true;
                    $this->logger->debug('Tipo tique was deleted successfully');
                }else {
                    $this->logger->debug('Tipo tique do not exists');
                }
            }

        }catch (\Exception $exception){
            $this->logger->debug('Something went wrong while trying to delete a tipo tique', array('exception'=>$exception));
        }

        return $result;
    }


    // Verifies if this current tipo tique is being used in some tique
    public function idInUse(): bool
    {
        $result = false;
        try {
            $sql = "SELECT COUNT(*) AS uso FROM tique WHERE id_tipo=:id_tipo";
            $st = $this->conn->prepare($sql);

            $st->bindValue(':id_tipo', $this->idTipoTique, PDO::PARAM_INT);

            $query = $st->execute();
            if( $query ) {
                $usage = $st->fetchColumn();
                if( $usage !== 0 ) {
                    $result = true;
                    $this->logger->debug('There is an usage of this tipo tique, It cannot be deleted');
                }else {
                    $this->logger->debug('There is no usage of the tipo tique id, It can be deleted');
                }
            }

            $st->closeCursor();
        }catch ( \Exception $exception){
            $this->logger->debug('Something went wrong while trying to verify the usage', array('exception'=>$exception));
        }

        return $result;
    }



}