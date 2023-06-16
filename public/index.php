<?php

require_once __DIR__.'/../vendor/autoload.php';

$router = new \Hetic\ReshomeApi\Router\Router();

$router->register('GET', '/api/test', function() {
    return json_encode(["message" => "Hello, world!"]);
});

$router->register('GET', '/api/get/announces', function () {
    $controller = new \Hetic\ReshomeApi\Controller\FrontController();
    isset($_GET['page']) ? $page = intval($_GET['page']) : $page = 1;
    $controller->getAnnounces($page);

});

$router->register('GET', '/api/get/announce', function () {
    if (isset($_GET['id'])) {
        $controller = new \Hetic\ReshomeApi\Controller\FrontController();
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
    $data = [
        'first_name' => htmlspecialchars($_POST['first_name']),
        'last_name' => htmlspecialchars($_POST['last_name']),
        'email' => htmlspecialchars($_POST['email']),
        'phone_number' => htmlspecialchars($_POST['phone_number']),
        'password' => htmlspecialchars($_POST['password']),
        'address' => htmlspecialchars($_POST['address']),
        'post_code' => htmlspecialchars($_POST['post_code']),
        'city' => htmlspecialchars($_POST['city']),
        'country' => htmlspecialchars($_POST['country']),
    ];

    $invalidCount = 0;
    foreach ($data as $value) {
        if (empty($value)) {
            $invalidCount += 1;
        }
    }

    if (!$invalidCount) {
        $controller = new \Hetic\ReshomeApi\Controller\AuthController();
        $controller->register($data);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['message' => $invalidCount . ' value(s) missing or invalid']);
    }
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->handleRequest($method, $uri);
