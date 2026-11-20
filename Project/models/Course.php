<?php
require_once __DIR__ . '/../config/database.php';

// Model untuk mengelola data Mata Kuliah (tabel courses)
class Course {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Mengambil seluruh data mata kuliah
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM courses ORDER BY semester, code");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Mengambil data mata kuliah berdasarkan ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Menambahkan mata kuliah baru
    public function create($data) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO courses (code, name, credits, semester, description)
                 VALUES (?, ?, ?, ?, ?)"
            );
            return $stmt->execute([
                $data['code'], $data['name'], $data['credits'],
                $data['semester'], $data['description']
            ]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) return 'duplicate';
            throw $e;
        }
    }

    // Memperbarui data mata kuliah
    public function update($id, $data) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE courses SET code=?, name=?, credits=?, semester=?, description=? WHERE id=?"
            );
            return $stmt->execute([
                $data['code'], $data['name'], $data['credits'],
                $data['semester'], $data['description'], $id
            ]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) return 'duplicate';
            throw $e;
        }
    }

    // Menghapus data mata kuliah
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
