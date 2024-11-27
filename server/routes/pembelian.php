<?php

require_once 'config.php';
require_once 'controllers/PembelianController.php';

$method = $_SERVER['REQUEST_METHOD'];
$pembelianController = new PembelianController($pdo);

switch ($method) {
    case "GET":
        if (isset($_GET['id'])) {
            $pembelianController->getPembelian($_GET['id']);
        } else {
            $pembelianController->getAllPembelian();
        }
        break;
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        $pembelianController->createPembelian($data);
        break;
    default:
        echo json_encode(["message" => "Method Not Allowed"]);
}
