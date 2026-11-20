<?php
require_once __DIR__ . '/../models/TeachingAssignment.php';
require_once __DIR__ . '/../models/Lecturer.php';
require_once __DIR__ . '/../models/Course.php';

// Controller untuk mengelola halaman dan aksi CRUD Jadwal Mengajar
class AssignmentController {
    private $model;

    public function __construct() {
        $this->model = new TeachingAssignment();
    }

    // Halaman daftar jadwal mengajar
    public function index() {
        $assignments = $this->model->getAll();
        require __DIR__ . '/../views/assignments/index.php';
    }

    // Halaman form tambah jadwal
    public function create() {
        $lecturers = (new Lecturer())->getAll();
        $courses   = (new Course())->getAll();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);

            if (empty($data['lecturer_id']) || empty($data['course_id']) || empty($data['academic_year'])
                || empty($data['day']) || empty($data['start_time']) || empty($data['end_time'])) {
                $error = 'Semua kolom wajib diisi kecuali ruangan.';
            } elseif ($data['start_time'] >= $data['end_time']) {
                $error = 'Waktu mulai harus lebih awal dari waktu selesai.';
            } else {
                $result = $this->model->create($data);
                if ($result === true) {
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Jadwal mengajar berhasil ditambahkan.'];
                    header('Location: index.php?page=assignments');
                    exit;
                } elseif ($result === 'invalid_reference') {
                    $error = 'Dosen atau mata kuliah tidak valid.';
                }
            }
        }

        require __DIR__ . '/../views/assignments/create.php';
    }

    // Halaman form edit jadwal
    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $assignment = $this->model->getById($id);
        if (!$assignment) {
            header('Location: index.php?page=assignments');
            exit;
        }

        $lecturers = (new Lecturer())->getAll();
        $courses   = (new Course())->getAll();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);

            if (empty($data['lecturer_id']) || empty($data['course_id']) || empty($data['academic_year'])
                || empty($data['day']) || empty($data['start_time']) || empty($data['end_time'])) {
                $error = 'Semua kolom wajib diisi kecuali ruangan.';
            } elseif ($data['start_time'] >= $data['end_time']) {
                $error = 'Waktu mulai harus lebih awal dari waktu selesai.';
            } else {
                $result = $this->model->update($id, $data);
                if ($result === true) {
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Jadwal berhasil diperbarui.'];
                    header('Location: index.php?page=assignments');
                    exit;
                } elseif ($result === 'invalid_reference') {
                    $error = 'Dosen atau mata kuliah tidak valid.';
                }
            }
            $assignment = array_merge($assignment, $data);
        }

        require __DIR__ . '/../views/assignments/edit.php';
    }

    // Aksi hapus jadwal
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if ($this->model->delete($id)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Jadwal berhasil dihapus.'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus jadwal.'];
            }
        }
        header('Location: index.php?page=assignments');
        exit;
    }

    // Sanitasi input form
    private function sanitize($post) {
        return [
            'lecturer_id'   => (int)($post['lecturer_id'] ?? 0),
            'course_id'     => (int)($post['course_id'] ?? 0),
            'academic_year' => trim($post['academic_year'] ?? ''),
            'day'           => trim($post['day'] ?? ''),
            'start_time'    => trim($post['start_time'] ?? ''),
            'end_time'      => trim($post['end_time'] ?? ''),
            'room'          => trim($post['room'] ?? ''),
        ];
    }
}
