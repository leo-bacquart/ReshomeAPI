<?php

require_once __DIR__.'/../vendor/autoload.php';

$router = new \Hetic\ReshomeApi\Router\Router();


$router->register('GET', '/api/test', function() {
    return json_encode(["message" => "Hello, world!"]);
});

$router->register('GET', '/api/get/announces', function () {
    $controller = new \Hetic\ReshomeApi\Controller\AnnounceController();
    isset($_GET['page']) ? $page = intval($_GET['page']) : $page = 1;
    $controller->getAnnounces($page);

});

$router->register('GET', '/api/get/announce', function () {
    if (isset($_GET['id'])) {
        $controller = new \Hetic\ReshomeApi\Controller\AnnounceController();
        $controller->getDetail($_GET['id']);
    }
});

$router->register('POST', '/api/auth/login', function () {
    $username = $_POST['email'];
    $password = $_POST['password'];

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $controller = new \Hetic\ReshomeApi\Controller\AuthController();
        $controller->login($username, $password);
    }
});

$router->register('POST', '/api/auth/register', function () {
    $controller = new \Hetic\ReshomeApi\Controller\AuthController();
    $controller->register();
});

$router->register('GET', '/api/auth/user', function () {
    $controller = new \Hetic\ReshomeApi\Controller\AuthController();
    $controller->getLoggedUser();
});

$router->register('POST', '/api/post/announce', function () {
    $controller = new \Hetic\ReshomeApi\Controller\AnnounceController();
    $controller->postAnnounce();
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->handleRequest($method, $uri);
