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

    public function __construct()
    {
        $this->logger = NewLogger::newLogger('TIQUE_MODEL');
        $this->conn = Connection::dbConnection();
    }

    public function setIdTique( int $id )
    {
        $this->id_tique = $id;
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





}