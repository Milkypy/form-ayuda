<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
/* echo $uri .'<br>';
echo $queryString .'<br>';
echo $_SERVER['SERVER_NAME'] .'<br>';
echo $_SERVER['HTTP_HOST'] .'<br>';
echo $_SERVER['PHP_SELF'] .'<br>'; */

$routes = [
    '/' => 'views/form-ayuda.php',
    '/solicitudes' => 'views/solicitudes.php',
    '/stats' => 'views/stats.php',
    '/404' => 'views/404.php',
];

if (array_key_exists($uri, $routes)) {
    require $routes[$uri] . ($queryString ?? '');
} else {
    require 'views/404.php';
    exit();
}