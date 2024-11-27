<?php

class ProdukController
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAllProduk()
    {
        $query = $this->db->query('SELECT * FROM produk');
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function getProduk($id)
    {
        $query = $this->db->query('SELECT * FROM produk WHERE id_produk=' . $id);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function createProduk($data)
    {
        $query = $this->db->prepare(
            'INSERT INTO produk (nama_produk, deskripsi, kategori, harga, stok_awal) VALUES (:nama_produk, :deskripsi, :kategori, :harga, :stok_awal)'
        );
        $query->execute([
            'nama_produk' => $data['nama_produk'],
            'deskripsi' => $data['deskripsi'],
            'kategori' => $data['kategori'],
            'harga' => $data['harga'],
            'stok_awal' => $data['stok_awal'],
        ]);
        echo json_encode(['success' => true, 'message' => 'Produk Berhasil Ditambahkan']);
    }

    public function updateProduk($data)
    {
        $query = $this->db->prepare(
            "UPDATE produk SET nama_produk = :nama_produk, deskripsi = :deskripsi, kategori = :kategori, harga = :harga 
             WHERE id_produk = :id"
        );
        $query->execute([
            'nama_produk' => $data['nama_produk'],
            'deskripsi'   => $data['deskripsi'],
            'kategori'    => $data['kategori'],
            'harga'       => $data['harga'],
            'id'          => $data['id_produk']
        ]);
        echo json_encode(["message" => "Produk updated"]);
    }

    public function deleteProduk($id)
    {
        $query = $this->db->prepare("DELETE FROM produk WHERE id_produk = :id");
        $query->execute(['id' => $id]);
        echo json_encode(["message" => "Produk deleted"]);
    }
}
