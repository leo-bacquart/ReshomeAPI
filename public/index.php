<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

require_once __DIR__.'/../vendor/autoload.php';

$router = new \Hetic\ReshomeApi\Router\Router();


$router->register('GET', '/api/test', function() {
    return json_encode(["message" => "Reshome API"]);
});

$router->register('GET', '/api/get/announces', function () {
    $controller = new \Hetic\ReshomeApi\Controller\AnnounceController();
    $controller->getAnnounces();
});

$router->register('GET', '/api/get/announce', function () {
        $controller = new \Hetic\ReshomeApi\Controller\AnnounceController();
        $controller->getDetail();
});

$router->register('GET', '/api/get/announce/reviews', function () {
    $controller = new \Hetic\ReshomeApi\Controller\ReviewController();
    $controller->getReviewByAnnounceId();
});

$router->register('POST', '/api/auth/login', function () {
    $controller = new \Hetic\ReshomeApi\Controller\AuthController();
    $controller->login();
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
    $controller->getSearch();
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

$router->register('POST', '/api/post/review', function () {
    $controller = new \Hetic\ReshomeApi\Controller\ReviewController();
    $controller->createReview();
});

$router->register('DELETE', '/api/delete/review', function () {
    $controller = new \Hetic\ReshomeApi\Controller\ReviewController();
    $controller->deleteReview();
});

$router->register('GET', '/api/get/users', function () {
    $controller = new \Hetic\ReshomeApi\Controller\UserController();
    $controller->getAllUsers();
});

$router->register('DELETE', '/api/delete/user', function () {
    $controller = new \Hetic\ReshomeApi\Controller\UserController();
    $controller->deleteUser();
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->handleRequest($method, $uri);

