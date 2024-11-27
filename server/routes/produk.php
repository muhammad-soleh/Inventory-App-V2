<?php
require_once 'config.php';
require_once 'controllers/ProdukController.php';

$method = $_SERVER['REQUEST_METHOD'];
$produkController = new ProdukController($pdo);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $produkController->getProduk($_GET['id']);
        } else {
            $produkController->getAllProduk();
        }
        break;
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        $produkController->createProduk($data);
        break;
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        $produkController->updateProduk($data);
        break;
    case "DELETE":
        if (isset($_GET['id'])) {
            $produkController->deleteProduk($_GET['id']);
        }
        break;
    default:
        echo json_encode(["message" => "Method not allowed"]);
}
