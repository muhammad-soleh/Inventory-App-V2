<?php

require_once 'config.php';
require_once 'controllers/HistoryController.php';

$method = $_SERVER['REQUEST_METHOD'];
$historyController = new HistoryController($pdo);

switch ($method) {

    case "GET":
        $historyController->getHistory();
        break;
    default:
        echo json_encode(['status' => 'error', "message" => "Method Not Allowed"]);
}
