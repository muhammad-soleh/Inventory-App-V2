<?php

require_once 'config.php';
require_once 'controllers/PenjualanController.php';

$method = $_SERVER['REQUEST_METHOD'];
$penjualanController = new PenjualanController($pdo);

switch ($method) {
    case "GET":
        if (isset($_GET['id'])) {
            $penjualanController->getPenjualan($_GET['id']);
        } else {
            $penjualanController->getAllPenjualan();
        }
        break;
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        $penjualanController->createPenjualan($data);
        break;
    default:
        echo json_encode(["message" => "Method Not Allowed"]);
}
