<?php
require_once __DIR__ . '../../db/conexion.php';
class Solicitud extends Conexion
{
    public function __construct()
    {
        parent::__construct();
    }
    protected function getSolicitudes(): string|array
    {
        $sql = "SELECT * FROM solicitudes";
        $stmt = sqlsrv_query($this->conexion, $sql);
        if (!$stmt) {
            return sqlsrv_errors()[0]['message'] ?? 'Error al obtener las solicitudes';
        }
        $solicitudes = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $solicitudes[] = $row;
        }
        return $solicitudes == [] ? 'No hay solicitudes' : $solicitudes;
    }
    protected function getSolicitud($id)
    {
        $sql = "SELECT * FROM solicitudes WHERE id = ?";
        $stmt = sqlsrv_query($this->conexion, $sql, array($id));
        $solicitud = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $solicitud = $row;
        }
        return $solicitud;
    }
    protected function createSolicitud($data_solicitud): string|array
    {
        $sql = "INSERT INTO [dbo].[solicitudes]
                   ([fecha_ingreso]
                   ,[last_mod]
                   ,[prioridad]
                   ,[estado]
                   ,[creado_por]
                   ,[calle]
                   ,[num_calle]
                   ,[sector]
                   ,[nombre]
                   ,[apaterno]
                   ,[amaterno]
                   ,[rut]
                   ,[observaciones]
                   ,[fono]
                   ,[mail])
                   OUTPUT INSERTED.folio_id
                VALUES
                     (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ";

        //validar parametros
        $this->validateParams($data_solicitud, $sql);

        $data = array(
            new DateTime('now'),
            new DateTime('now'),
            $data_solicitud['prioridad'],
            $data_solicitud['estado'],
            $data_solicitud['creado_por'],
            $data_solicitud['calle'],
            $data_solicitud['num_calle'],
            $data_solicitud['sector'],
            $data_solicitud['nombre'],
            $data_solicitud['apaterno'],
            $data_solicitud['amaterno'],
            $data_solicitud['rut'],
            $data_solicitud['observaciones'],
            $data_solicitud['fono'],
            $data_solicitud['mail'],
        );
        //preparar la consulta
        $stmnt = sqlsrv_prepare($this->conexion, $sql, $data);
        if (!$stmnt) {
            return sqlsrv_errors()[0]['message'] ?? 'Error al crear la solicitud';
        }
        //ejecutar la consulta
        $result = sqlsrv_execute($stmnt);
        if (!$result) {
            return sqlsrv_errors()[0]['message'] ?? 'Error al crear la solicitud';
        }
        //obtener el folio_id
        $folio_id = sqlsrv_fetch_array($stmnt, SQLSRV_FETCH_ASSOC);
        if (!$folio_id) {
            return sqlsrv_errors()[0]['message'] ?? 'Error al crear la solicitud';
        }
        return $folio_id;
    }
    protected function updateSolicitud($id, $nombre, $email, $telefono, $mensaje)
    {
        $sql = "UPDATE solicitudes SET nombre = ?, email = ?, telefono = ?, mensaje = ? WHERE id = ?";
        $stmt = sqlsrv_query($this->conexion, $sql, array($nombre, $email, $telefono, $mensaje, $id));
        return $stmt;
    }
    protected function deleteSolicitud($id)
    {
        $sql = "DELETE FROM solicitudes WHERE id = ?";
        $stmt = sqlsrv_query($this->conexion, $sql, array($id));
        return $stmt;
    }

    protected function getDireccionesRegistradas(string $param, int $limit): string|array
    {
        //obtiene las direcciones (calle y numero de calle) registradas en tabla solicitudes
        $sql = "SELECT TOP (?) folio_id, calle, num_calle FROM solicitudes WHERE calle LIKE Concat('%',?,'%') OR num_calle LIKE Concat('%',?,'%') ";
        
        $stmt = sqlsrv_query($this->conexion, $sql, array($limit, $param, $param));
        if (!$stmt) {
            return sqlsrv_errors()[0]['message'];
        }

        $direcciones = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $direcciones[] = $row;
        }
        return $direcciones != null ? $direcciones : 'No hay direcciones registradas';
    }
}