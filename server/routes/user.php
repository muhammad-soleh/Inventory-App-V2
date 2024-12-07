<?php
require_once 'config.php';
require_once 'controllers/UserController.php';

$method = $_SERVER['REQUEST_METHOD'];
$userController = new UserController($pdo);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $userController->getUser($_GET['id']);
        } else {
            $userController->getAllUser();
        }
        break;
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        $userController->createUser($data);
        break;
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        $userController->updateUser($data);
        break;
    case "DELETE":
        if (isset($_GET['id'])) {
            $userController->deleteUser($_GET['id']);
        }
        break;
    default:
        echo json_encode(["message" => "Method not allowed"]);
}
