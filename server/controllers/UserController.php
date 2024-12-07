<?php
require './auth_middleware_token.php';
class UserController
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAllUser()
    {
        try {
            $query = $this->db->query('SELECT * FROM users');
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['data' => $result, 'user' => verifyToken()]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal Query ' . $e->getMessage()]);
        }
    }

    public function getUser($id)
    {
        try {

            $query = $this->db->query('SELECT * FROM users WHERE id_user=' . $id);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['data' => $result]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal Query ' . $e->getMessage()]);
        }
    }

    public function createUser($data)
    {
        try {

            if ($data['password']) {
                $password_baru =  password_hash($data['password'], PASSWORD_BCRYPT);
            }
            $query = $this->db->prepare(
                'INSERT INTO users (username, email, password, full_name, role, created_at, updated_at) VALUES (:username, :email, :password, :full_name, :role, NOW(), NOW())'
            );
            $query->execute([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $password_baru,
                'full_name' => $data['full_name'],
                'role' => $data['role'],
            ]);
            echo json_encode(['success' => true, 'message' => 'User Berhasil Ditambahkan']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal Query ' . $e->getMessage()]);
        }
    }

    public function updateUser($data)
    {
        try {
            // echo json_encode(['data' => $data]);
            // die;
            $password_baru = password_hash($data['password'], PASSWORD_BCRYPT);
            $query = $this->db->prepare(
                "UPDATE users SET username = :username, email = :email, password = :password, full_name = :full_name, role = :role 
             WHERE id_user = :id"
            );
            $query->execute([
                'username' => $data['username'],
                'email'   => $data['email'],
                'password'    => $password_baru,
                'full_name'       => $data['full_name'],
                'role'       => $data['role'],
                'id'          => $data['id_user']
            ]);
            echo json_encode(['succes' => true, "message" => "User updated"]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal Query ' . $e->getMessage()]);
        }
    }

    public function deleteUser($id)
    {
        try {
            $query = $this->db->prepare("DELETE FROM users WHERE id_user = :id");
            $query->execute(['id' => $id]);
            echo json_encode(['status' => 'berhasil', "message" => "User deleted"]);
        } catch (\Throwable $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal Query ' . $e->getMessage()]);
        }
    }
}
