<?php
require './auth_middleware_token.php';
class ProdukController
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAllProduk()
    {
        try {
            $query = $this->db->query('SELECT * FROM produk');
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['data' => $result, 'user' => verifyToken()]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal Query ' . $e->getMessage()]);
        }
    }

    public function getProduk($id)
    {
        try {

            $query = $this->db->query('SELECT * FROM produk WHERE id_produk=' . $id);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['data' => $result, 'user' => verifyToken()]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal Query ' . $e->getMessage()]);
        }
    }
    public function createProduk($data)
    {
        try {
            $query = $this->db->prepare(
                'INSERT INTO produk (nama_produk, deskripsi, kategori, harga, stok_awal,id_user) VALUES (:nama_produk, :deskripsi, :kategori, :harga, :stok_awal,:id_user)'
            );
            $query->execute([
                'nama_produk' => $data['nama_produk'],
                'deskripsi' => $data['deskripsi'],
                'kategori' => $data['kategori'],
                'harga' => $data['harga'],
                'stok_awal' => $data['stok_awal'],
                'id_user' => $data['id_user'],
            ]);
            echo json_encode(['success' => true, 'message' => 'Produk Berhasil Ditambahkan']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal Query' . $e->getMessage()]);
        }
    }

    public function updateProduk($data)
    {
        try {
            $query = $this->db->prepare(
                "UPDATE produk SET nama_produk = :nama_produk, deskripsi = :deskripsi, kategori = :kategori, harga = :harga
             WHERE id_produk = :id"
            );
            $query->execute([
                'nama_produk' => $data['nama_produk'],
                'deskripsi'   => $data['deskripsi'],
                'kategori'    => $data['kategori'],
                'harga'       => $data['harga'],
                'id'          => $data['id_produk'],
            ]);
            echo json_encode(['succes' => true, "message" => "Produk updated"]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal Query' . $e->getMessage()]);
        }
    }

    public function deleteProduk($id)
    {
        $query = $this->db->prepare("DELETE FROM produk WHERE id_produk = :id");
        $query->execute(['id' => $id]);
        echo json_encode(["message" => "Produk deleted"]);
    }
}
