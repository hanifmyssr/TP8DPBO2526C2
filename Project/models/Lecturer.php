<?php
require_once __DIR__ . '/../config/database.php';

// Model untuk mengelola data Dosen (tabel lecturers)
class Lecturer {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Mengambil seluruh data dosen
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM lecturers ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Mengambil data dosen berdasarkan ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM lecturers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Menambahkan data dosen baru
    public function create($data) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO lecturers (name, nidn, email, phone, specialization, join_date)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            return $stmt->execute([
                $data['name'], $data['nidn'], $data['email'],
                $data['phone'], $data['specialization'], $data['join_date']
            ]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) return 'duplicate';
            throw $e;
        }
    }

    // Memperbarui data dosen
    public function update($id, $data) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE lecturers SET name=?, nidn=?, email=?, phone=?, specialization=?, join_date=? WHERE id=?"
            );
            return $stmt->execute([
                $data['name'], $data['nidn'], $data['email'],
                $data['phone'], $data['specialization'], $data['join_date'], $id
            ]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) return 'duplicate';
            throw $e;
        }
    }

    // Menghapus data dosen berdasarkan ID
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM lecturers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
