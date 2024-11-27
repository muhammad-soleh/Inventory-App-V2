<?php

class UtilitiesController
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAllProduk()
    {
        $query = $this->db->prepare("SELECT produk.*, stok.stok_terkini 
        FROM produk 
        JOIN stok ON produk.id_produk = stok.id_produk");
        $query->execute();

        // Ambil hasil query
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }
    public function getProdukPenjualan()
    {
        $query = $this->db->prepare("SELECT produk.nama_produk, penjualan.* 
        FROM produk 
        JOIN penjualan ON produk.id_produk = penjualan.id_produk");
        $query->execute();

        // Ambil hasil query
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        // echo "test";
    }
    public function getProdukPembelian()
    {
        $query = $this->db->prepare("SELECT produk.nama_produk, pembelian.* 
        FROM produk 
        JOIN pembelian ON produk.id_produk = pembelian.id_produk");
        $query->execute();

        // Ambil hasil query
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        // echo "test";
    }
}
