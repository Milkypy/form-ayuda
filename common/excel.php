<?php

//CONTROLADOR DE SOLICITUDES
require_once __DIR__ . '/../controller/ctrl-solicitudes.php';

$solicitudesCtrl = new SolicitudCtrl();
$solicitudes = $solicitudesCtrl->getFullSolicitudesCtrl();

// var_dump($solicitudes);
// Excel file name for download 
$fileName = "Reporte Solicitudes " . date('Y-m-d') . ".xls";

// Column names 
$headers = array(
    'FOLIO SOLICITUD',
    'FECHA SOLICITUD',
    'SECTOR',
    'PRIORIDAD',
    'ITEMS',
    'ESTATUS',
    'CALLE',
    'NUMERACION',
    'RUT SOLICITANTE',
    'NOMBRE SOLICITANTE',
    'TELEFONO SOLICITANTE',
    'CORREO SOLICITANTE',
    'OBSERVACIONES'
);

// Crear un archivo Excel en formato XML
$excelContent = '<?xml version="1.0" encoding="UTF-8"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <Worksheet ss:Name="Sheet1">
  <Table>';

//titulo 
$excelContent .= '<Row><Cell><Data ss:Type="String">SOLICITUDES DE AYUDA </Data></Cell></Row>';

// Agregar encabezados
$excelContent .= '<Row>';
foreach ($headers as $header) {
    $excelContent .= '<Cell><Data ss:Type="String">' . $header . '</Data></Cell>';
}
$excelContent .= '</Row>';

// Agregar datos
foreach ($solicitudes as $solicitud) {
    $excelContent .= '<Row>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['folio_id'] . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . date_format(new DateTime($solicitud['fecha_ingreso']), 'Y-m-d H:i') . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['sector'] . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['prioridad'] == 1 ? 'Común' : 'Adultos Mayores/Menores de Edad' . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">';
    foreach ($solicitud['items'] as $item) {
        $excelContent .= $item . '-';
    }
    $excelContent .= '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['estado'] == 0 ? 'Recibida' : 'Entregada' . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['calle'] . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['num_calle'] . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['rut'] . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['nombre'] . ' ' . $solicitud['apaterno'] . ' ' . $solicitud['amaterno'] . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['fono'] . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['mail'] . '</Data></Cell>';
    $excelContent .= '<Cell><Data ss:Type="String">' . $solicitud['observaciones'] . '</Data></Cell>';
    $excelContent .= '</Row>';
}

// Cerrar el archivo Excel
$excelContent .= '</Table></Worksheet></Workbook>';

// Escribir el archivo Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Pragma: no-cache");
header("Expires: 0");
echo $excelContent;
exit;
