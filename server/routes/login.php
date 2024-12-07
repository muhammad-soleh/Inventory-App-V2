<?php

require_once 'config.php';
require_once 'controllers/LoginController.php';


$method = $_SERVER['REQUEST_METHOD'];
$loginController = new LoginController($pdo);

switch ($method) {
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        $loginController->login($data);
        break;
    default:
        echo json_encode(["message" => "Method not Allowed"]);
}
