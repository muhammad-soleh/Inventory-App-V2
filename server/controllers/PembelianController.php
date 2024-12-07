<?php
require './auth_middleware_token.php'; // Middleware verifikasi token

class PembelianController
{
    private $db;


    public function __construct($pdo)
    {
        $this->db = $pdo;
    }


    public function createPembelian($data)
    {
        try {

            $query = $this->db->prepare(
                'INSERT INTO pembelian (id_produk,id_user, jumlah, harga_satuan, total_harga, tanggal) VALUES (:id_produk, :id_user, :jumlah, :harga_satuan, :total_harga, NOW())'
            );

            $query->execute([
                'id_produk' => $data['id_produk'],
                'id_user' => $data['id_user'],
                'jumlah' => $data['jumlah'],
                'harga_satuan' => $data['harga_satuan'],
                'total_harga' => $data['total_harga'],
            ]);
            echo json_encode(['message' => 'Pembelian Berhasil Ditambahkan']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambah produk' . $e->getMessage()]);
        }
    }
}
