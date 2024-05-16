<?php
require_once __DIR__ . '../../models/solicitud.php';
class SolicitudCtrl extends Solicitud
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getSolicitudesCtrl()
    {
        $solicitudes = $this->getSolicitudes();
        return $solicitudes;
    }
    public function getSolicitudCtrl($id)
    {
        $solicitud = $this->getSolicitud($id);
        return $solicitud;
    }

    public function createSolicitudCtrl(array $data_solicitud = array()): string|array
    {
        //limpiar los datos
        $data_solicitud = array_map(array($this, 'protect_text'), $data_solicitud);

        //agrega fecha_ingreso, creado_por, estado y last_mod
        $data_solicitud['fecha_ingreso'] = new DateTime('now');
        $data_solicitud['last_mod'] = new DateTime('now');
        $data_solicitud['estado'] = 1;
        $data_solicitud['creado_por'] = null;

        if (!$data_solicitud || empty($data_solicitud)) {
            return 'No hay datos para crear la solicitud';
        }
        $result = $this->createSolicitud($data_solicitud);
        return $result;
    }


    public function updateSolicitudCtrl($id, $nombre, $email, $telefono, $mensaje)
    {
        $stmt = $this->updateSolicitud($id, $nombre, $email, $telefono, $mensaje);
        return $stmt;
    }
    public function deleteSolicitudCtrl($id)
    {
        $stmt = $this->deleteSolicitud($id);
        return $stmt;
    }

    public function getDirecciones($query, $limit)
    {
        require_once __DIR__ . '../../common/utils.php';
        $utils = new Utils();
        $query = $utils->sanitizar($query);
        $limit = $utils->sanitizar($limit);
        return $this->getDireccionesRegistradas($query, $limit);

    }
}