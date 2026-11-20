<?php
require_once __DIR__ . '/../models/Course.php';

// Controller untuk mengelola halaman dan aksi CRUD Mata Kuliah
class CourseController {
    private $model;

    public function __construct() {
        $this->model = new Course();
    }

    // Halaman daftar mata kuliah
    public function index() {
        $courses = $this->model->getAll();
        require __DIR__ . '/../views/courses/index.php';
    }

    // Halaman form tambah mata kuliah
    public function create() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);

            if (empty($data['code']) || empty($data['name']) || empty($data['credits']) || empty($data['semester'])) {
                $error = 'Kolom Code, Name, Credits, dan Semester wajib diisi.';
            } elseif ($data['credits'] < 1 || $data['credits'] > 6) {
                $error = 'SKS harus antara 1-6.';
            } elseif ($data['semester'] < 1 || $data['semester'] > 8) {
                $error = 'Semester harus antara 1-8.';
            } else {
                $result = $this->model->create($data);
                if ($result === true) {
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Mata kuliah berhasil ditambahkan.'];
                    header('Location: index.php?page=courses');
                    exit;
                } elseif ($result === 'duplicate') {
                    $error = 'Kode mata kuliah sudah terdaftar.';
                }
            }
        }

        require __DIR__ . '/../views/courses/create.php';
    }

    // Halaman form edit mata kuliah
    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $course = $this->model->getById($id);
        if (!$course) {
            header('Location: index.php?page=courses');
            exit;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);

            if (empty($data['code']) || empty($data['name']) || empty($data['credits']) || empty($data['semester'])) {
                $error = 'Kolom Code, Name, Credits, dan Semester wajib diisi.';
            } else {
                $result = $this->model->update($id, $data);
                if ($result === true) {
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Mata kuliah berhasil diperbarui.'];
                    header('Location: index.php?page=courses');
                    exit;
                } elseif ($result === 'duplicate') {
                    $error = 'Kode mata kuliah sudah digunakan.';
                }
            }
            $course = array_merge($course, $data);
        }

        require __DIR__ . '/../views/courses/edit.php';
    }

    // Aksi hapus mata kuliah
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if ($this->model->delete($id)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Mata kuliah berhasil dihapus.'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus mata kuliah.'];
            }
        }
        header('Location: index.php?page=courses');
        exit;
    }

    // Sanitasi input form
    private function sanitize($post) {
        return [
            'code'        => trim($post['code'] ?? ''),
            'name'        => trim($post['name'] ?? ''),
            'credits'     => (int)($post['credits'] ?? 0),
            'semester'    => (int)($post['semester'] ?? 0),
            'description' => trim($post['description'] ?? ''),
        ];
    }
}
