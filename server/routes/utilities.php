<?php

require_once 'controllers/UtilitiesController.php';
require_once 'config.php';
$utilitiesController = new UtilitiesController($pdo);

switch ($resource) {
    case 'getStockProduk':
        $utilitiesController->getAllProduk();
        break;
    case 'getProdukPenjualan':
        $utilitiesController->getProdukPenjualan();
        break;
    case 'getProdukPembelian':
        $utilitiesController->getProdukPembelian();
        break;
}
