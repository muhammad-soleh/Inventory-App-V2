<?php

class PembelianController
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAllPembelian()
    {
        $query = $this->db->query('SELECT * FROM pembelian');
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function getPembelian($id)
    {
        $query = $this->db->query('SELECT * FROM pembelian WHERE id_pembelian=' . $id);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function createPembelian($data)
    {
        $query = $this->db->prepare(
            'INSERT INTO pembelian (id_produk, jumlah, harga_satuan, total_harga, tanggal) VALUES (:id_produk, :jumlah, :harga_satuan, :total_harga, NOW())'
        );

        $query->execute([
            'id_produk' => $data['id_produk'],
            'jumlah' => $data['jumlah'],
            'harga_satuan' => $data['harga_satuan'],
            'total_harga' => $data['total_harga'],
        ]);
        echo json_encode(['message' => 'Pembelian Berhasil Ditambahkan']);
    }
}
