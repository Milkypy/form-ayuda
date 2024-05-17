<?php

// Set the content type header to JSON
header('Access-Control-Allow-Origin: same-origin');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

//check if the user is logged in
// session_start();
// if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
//     http_response_code(401);
//     echo json_encode(['message' => 'Unauthorized']);
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
    exit();
}

//valida que el parametro action exista
if (!isset($_GET['action']) || empty($_GET['action'])) {
    http_response_code(400);
    echo json_encode(['message' => 'parametro action no encontrado']);
    exit();
}


// Get the query parameter from the URL
$query = $_GET['q'] ?? null;

// Get the limit parameter from the URL
$limit = $_GET['limit'] ?? 20;

switch ($_GET['action']) {
    case 'getFullSolicitudes':
        // call the getDirecciones method from the solicitud Controller class
        require_once '../controller/ctrl-solicitudes.php';
        $sctrl = new SolicitudCtrl();
        $direcciones = $sctrl->getFullSolicitudesCtrl();
        echo json_encode($direcciones);
        break;
    case 'getDireccionesRegistradas':
        // call the getDireccionesRegistradas method from the solicitud Controller class
        require_once '../controller/ctrl-solicitudes.php';
        $sctrl = new SolicitudCtrl();
        $direcciones = $sctrl->getDireccionesRegistradas($query, $limit);
        echo json_encode($direcciones);
        break;
    default:
        http_response_code(400);
        echo json_encode(['message' => 'Invalid action']);
        break;
}

