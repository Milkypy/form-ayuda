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

if (!isset($_GET['q']) || empty($_GET['q'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing query parameter']);
    exit();
}


// Get the query parameter from the URL
$query = $_GET['q'] ?? null;

// Get the limit parameter from the URL
$limit = $_GET['limit'] ?? 20;

// call the getDirecciones method from the solicitud Controller class
require_once '../controller/ctrl-solicitudes.php';
$sctrl = new SolicitudCtrl();
$direcciones = $sctrl->getDirecciones($query, $limit);
echo json_encode($direcciones);
exit();
