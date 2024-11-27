<?php

header("Access-Control-Allow-Origin: *"); // Mengizinkan semua domain
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Hentikan eksekusi jika metode adalah OPTIONS (preflight request)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$request = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));
$req = $request[1] ?? '';
if ($req) {
    $resource = $request[1] ?? '';

    include 'routes/utilities.php';

    die;
}
$resource = $request[0] ?? ''; // localhost/produk mengambil produk 

switch ($resource) {
    case 'produk':
        include 'routes/produk.php';
        break;
    case 'pembelian':
        include 'routes/pembelian.php';
        break;
    case 'penjualan':
        include 'routes/penjualan.php';
        break;
    default:
        echo json_encode(["message" => "Resource Not Found"]);
}
