<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LoginController
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function login($data)
    {
        try {
            $secret_key = "SLOHEHJANGNO"; // Simpan kunci rahasia ini dengan aman.
            $issued_at = time();
            $expiration_time = $issued_at + (60 * 60);
            $query = $this->db->prepare('SELECT * FROM users WHERE username=:username');
            $query->execute([
                'username' => $data['username']
            ]);

            $user = $query->fetchAll(PDO::FETCH_ASSOC);
            // echo $user[0]['id_user'];
            if ($user && password_verify($data['password'], $user[0]['password'])) {
                $payload = [
                    'id_user' => $user[0]['id_user'],
                    'username' => $user[0]['username'],
                    'role' => $user[0]['role'],
                    'iat' => $issued_at,
                    'exp' => $expiration_time
                ];

                $jwt = JWT::encode($payload, $secret_key, 'HS256');

                echo json_encode(['token' => $jwt]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Username atau password salah'
                ]);
            }
        } catch (Exception $e) {
            die(json_encode(['status' => 'error', 'message' => 'Error Query' . $e->getMessage()]));
        }
    }
}
