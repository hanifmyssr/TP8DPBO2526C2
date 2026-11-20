<?php
require_once __DIR__ . '/../config/database.php';

// Model untuk mengelola Jadwal Mengajar (tabel teaching_assignments)
class TeachingAssignment {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Mengambil semua jadwal dengan JOIN ke tabel lecturers dan courses
    public function getAll() {
        $stmt = $this->db->prepare(
            "SELECT ta.*, l.name AS lecturer_name, l.nidn,
                    c.name AS course_name, c.code AS course_code, c.credits
             FROM teaching_assignments ta
             JOIN lecturers l ON ta.lecturer_id = l.id
             JOIN courses c ON ta.course_id = c.id
             ORDER BY FIELD(ta.day, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), ta.start_time"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Mengambil jadwal berdasarkan ID
    public function getById($id) {
        $stmt = $this->db->prepare(
            "SELECT ta.*, l.name AS lecturer_name, c.name AS course_name
             FROM teaching_assignments ta
             JOIN lecturers l ON ta.lecturer_id = l.id
             JOIN courses c ON ta.course_id = c.id
             WHERE ta.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Menambahkan jadwal mengajar baru
    public function create($data) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO teaching_assignments (lecturer_id, course_id, academic_year, day, start_time, end_time, room)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            return $stmt->execute([
                $data['lecturer_id'], $data['course_id'], $data['academic_year'],
                $data['day'], $data['start_time'], $data['end_time'], $data['room']
            ]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1452) return 'invalid_reference';
            throw $e;
        }
    }

    // Memperbarui jadwal mengajar
    public function update($id, $data) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE teaching_assignments
                 SET lecturer_id=?, course_id=?, academic_year=?, day=?, start_time=?, end_time=?, room=?
                 WHERE id=?"
            );
            return $stmt->execute([
                $data['lecturer_id'], $data['course_id'], $data['academic_year'],
                $data['day'], $data['start_time'], $data['end_time'], $data['room'], $id
            ]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1452) return 'invalid_reference';
            throw $e;
        }
    }

    // Menghapus jadwal mengajar
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM teaching_assignments WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
