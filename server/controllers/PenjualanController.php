<?php

class PenjualanController
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAllPenjualan()
    {
        $query = $this->db->query('SELECT * FROM penjualan');
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function getPenjualan($id)
    {
        $query = $this->db->query('SELECT * FROM penjualan WHERE id_penjualan=' . $id);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function createPenjualan($data)
    {
        $query = $this->db->prepare(
            'INSERT INTO penjualan (id_produk, jumlah, harga_satuan, total_harga, tanggal) VALUES (:id_produk, :jumlah, :harga_satuan, :total_harga, NOW())'
        );

        $query->execute([
            'id_produk' => $data['id_produk'],
            'jumlah' => $data['jumlah'],
            'harga_satuan' => $data['harga_satuan'],
            'total_harga' => $data['total_harga'],
        ]);
        echo json_encode(['message' => 'Penjualan Berhasil Ditambahkan']);
    }
}
