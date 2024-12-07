<?php

class PenjualanController
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function createPenjualan($data)
    {
        try {
            $query = $this->db->prepare(
                'INSERT INTO penjualan (id_produk,id_user, jumlah, harga_satuan, total_harga, tanggal) VALUES (:id_produk,:id_user, :jumlah, :harga_satuan, :total_harga, NOW())'
            );

            $query->execute([
                'id_produk' => $data['id_produk'],
                'id_user' => $data['id_user'],
                'jumlah' => $data['jumlah'],
                'harga_satuan' => $data['harga_satuan'],
                'total_harga' => $data['total_harga'],
            ]);
            echo json_encode(['message' => 'Penjualan Berhasil Ditambahkan']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal Query' + $e->getMessage()]);
        }
    }
}
