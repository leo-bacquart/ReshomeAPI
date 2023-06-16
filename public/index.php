<?php

require_once __DIR__.'/../vendor/autoload.php';

$router = new \Hetic\ReshomeApi\Router\Router();

$router->register('GET', '/api/test', function() {
    return json_encode(["message" => "Hello, world!"]);
});

$router->register('GET', '/api/get/announces', function () {
    $controller = new \Hetic\ReshomeApi\Controller\FrontController();
    $controller->getAnnounces();
});

$router->register('GET', '/api/get/announce/', function () {
    if (isset($_GET['id'])) {
        $controller = new \Hetic\ReshomeApi\Controller\FrontController();
        $controller->getDetail($_GET['id']);
    }
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->handleRequest($method, $uri);
