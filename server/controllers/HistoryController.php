<?php
require './auth_middleware_token.php'; // Middleware verifikasi token

class HistoryController
{
    private $db;


    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getHistory()
    {
        try {
            $query = $this->db->prepare("SELECT history.*, produk.nama_produk 
    FROM history 
    JOIN produk ON history.id_produk = produk.id_produk ORDER BY history.tanggal DESC");
            $query->execute();

            // Ambil hasil query
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['data' => $result, 'user' => verifyToken()]);
        } catch (Exception $e) {
            echo json_encode(['status' => "error", 'message' => 'Gagal Query ' . $e->getMessage()]);
        }
    }
}
