<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

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

$router->register('GET', '/api/get/self', function () {
    $controller = new \Hetic\ReshomeApi\Controller\UserController();
    $controller->getLoggedUser();
});

$router->register('POST', '/api/post/announce', function () {
    $controller = new \Hetic\ReshomeApi\Controller\AnnounceController();
    $controller->createAnnounce();
});

$router->register('GET', '/api/get/user', function ()
{
    $controller = new \Hetic\ReshomeApi\Controller\UserController();
    $controller->getUserDetails($_GET['id']);
});

$router->register('GET', '/api/get/pictures', function () {
    $controller = new \Hetic\ReshomeApi\Controller\PictureController();
    $controller->getPicturesPath($_GET['id']);
});

$router->register('GET', '/api/get/search', function () {
    $controller = new \Hetic\ReshomeApi\Controller\AnnounceController();
    $controller->getSearch($_GET['q']);
});

$router->register('POST', '/api/post/reservation', function () {
    $controller = new \Hetic\ReshomeApi\Controller\ReservationController();
    $controller->createReservation();
});

$router->register('GET', '/api/get/reservations/announce', function () {
    $controller = new \Hetic\ReshomeApi\Controller\ReservationController();
    $controller->getReservationsByAnnounceId();
});

$router->register('GET', '/api/get/reservations/self', function () {
    $controller = new \Hetic\ReshomeApi\Controller\ReservationController();
    $controller->getSelfReservations();
});

$router->register('GET', '/api/get/reservation', function () {
    $controller = new \Hetic\ReshomeApi\Controller\ReservationController();
    $controller->getReservationDetail();
});


$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->handleRequest($method, $uri);

