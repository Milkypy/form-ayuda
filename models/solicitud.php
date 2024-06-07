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
    protected function createSolicitud($data_solicitud, $data_items): array
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
        $sql_items = "INSERT INTO [dbo].[solicitudes_has_items]
                     ([folio_id]
                     ,[item_id])
                    VALUES
                     (?,?)";

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

        sqlsrv_begin_transaction($this->conexion);
        //insertar solicitud
        $stmt1 = sqlsrv_prepare($this->conexion, $sql, $data);
        if (!$stmt1) {
            sqlsrv_rollback($this->conexion);
            sqlsrv_close($this->conexion);
            return ['success' => false, 'err' => sqlsrv_errors()[0]['message']];
        }
        $result = sqlsrv_execute($stmt1);
        if (!$result) {
            sqlsrv_rollback($this->conexion);
            sqlsrv_free_stmt($stmt1);
            sqlsrv_close($this->conexion);
            return ['success' => false, 'err' => sqlsrv_errors()[0]['message']];
        }
        //insertar items
        $folio_id = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)['folio_id'];
        foreach ($data_items as $item) {
            $stmt2 = sqlsrv_prepare($this->conexion, $sql_items, array($folio_id, $item));
            if (!$stmt2) {
                sqlsrv_rollback($this->conexion);
                sqlsrv_free_stmt($stmt1);
                sqlsrv_close($this->conexion);
                return ['success' => false, 'err' => sqlsrv_errors()[0]['message']];
            }
            $result = sqlsrv_execute($stmt2);
            if (!$result) {
                sqlsrv_rollback($this->conexion);
                sqlsrv_free_stmt($stmt1);
                sqlsrv_free_stmt($stmt2);
                sqlsrv_close($this->conexion);
                return ['success' => false, 'err' => sqlsrv_errors()[0]['message'] ?? 'Error al insertar items'];
            }
        }
        sqlsrv_commit($this->conexion);
        sqlsrv_free_stmt($stmt1);
        sqlsrv_free_stmt($stmt2);
        sqlsrv_close($this->conexion);

        return ['success' => true, 'folio_id' => $folio_id];
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
        $sql = "SELECT TOP (?) [folio_id]
                ,[fecha_ingreso]
                ,[last_mod]
                ,[prioridad]
                ,[estado]
                ,[creado_por]
                ,[calle]
                ,[num_calle]
                ,[nombre]
                ,[apaterno]
                ,[amaterno]
                ,[rut]
                ,[ruta]
                ,[mail]
                ,[fono]
                ,[observaciones]
                ,sectores.sector
                FROM solicitudes
                inner join sectores on solicitudes.sector = sectores.sector_id
                WHERE calle LIKE Concat('%',?,'%') OR num_calle LIKE Concat('%',?,'%')";

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

    protected function getFullSolicitudes(): string|array
    {
        $sql = "SELECT solicitudes.folio_id,
                        solicitudes.fecha_ingreso, 
                        solicitudes.last_mod, 
                        solicitudes.prioridad, 
                        solicitudes.estado, 
                        solicitudes.calle, 
                        solicitudes.num_calle, 
                        sectores.sector, 
                        solicitudes.nombre, 
                        solicitudes.apaterno, 
                        solicitudes.amaterno, 
                        solicitudes.rut, 
                        solicitudes.observaciones, 
                        solicitudes.fono, 
                        solicitudes.mail, 
                        items.item,
                        solicitudes.creado_por
                FROM solicitudes
                INNER JOIN sectores ON solicitudes.sector = sectores.sector_id
                INNER JOIN solicitudes_has_items ON solicitudes.folio_id = solicitudes_has_items.folio_id
                INNER JOIN items ON solicitudes_has_items.item_id = items.item_id";
        $stmt = sqlsrv_query($this->conexion, $sql);
        if (!$stmt) {
            return sqlsrv_errors()[0]['message'];
        }
        $solicitudes = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            //si la solicitud ya esta en el array, agregar el item
            if (array_key_exists($row['folio_id'], $solicitudes)) {
                $solicitudes[$row['folio_id']]['items'][] = $row['item'];
            } else {
                $solicitudes[$row['folio_id']] = $row;
                $solicitudes[$row['folio_id']]['items'] = array($row['item']);
            }
        }
        return $solicitudes != null ? $solicitudes : 'No hay solicitudes';
    }
}