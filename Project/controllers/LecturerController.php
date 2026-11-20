<?php
require_once __DIR__ . '/../models/Lecturer.php';

// Controller untuk mengelola halaman dan aksi CRUD Dosen
class LecturerController {
    private $model;

    public function __construct() {
        $this->model = new Lecturer();
    }

    // Halaman daftar dosen
    public function index() {
        $lecturers = $this->model->getAll();
        require __DIR__ . '/../views/lecturers/index.php';
    }

    // Halaman form tambah dosen
    public function create() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);

            if (empty($data['name']) || empty($data['nidn']) || empty($data['join_date'])) {
                $error = 'Kolom Name, NIDN, dan Join Date wajib diisi.';
            } elseif ($data['email'] && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error = 'Format email tidak valid.';
            } else {
                $result = $this->model->create($data);
                if ($result === true) {
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Dosen berhasil ditambahkan.'];
                    header('Location: index.php?page=lecturers');
                    exit;
                } elseif ($result === 'duplicate') {
                    $error = 'NIDN atau email sudah terdaftar.';
                } else {
                    $error = 'Gagal menyimpan data.';
                }
            }
        }

        require __DIR__ . '/../views/lecturers/create.php';
    }

    // Halaman form edit dosen
    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $lecturer = $this->model->getById($id);
        if (!$lecturer) {
            header('Location: index.php?page=lecturers');
            exit;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);

            if (empty($data['name']) || empty($data['nidn']) || empty($data['join_date'])) {
                $error = 'Kolom Name, NIDN, dan Join Date wajib diisi.';
            } elseif ($data['email'] && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error = 'Format email tidak valid.';
            } else {
                $result = $this->model->update($id, $data);
                if ($result === true) {
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data dosen berhasil diperbarui.'];
                    header('Location: index.php?page=lecturers');
                    exit;
                } elseif ($result === 'duplicate') {
                    $error = 'NIDN atau email sudah digunakan dosen lain.';
                }
            }
            // Isi ulang form dengan data POST
            $lecturer = array_merge($lecturer, $data);
        }

        require __DIR__ . '/../views/lecturers/edit.php';
    }

    // Aksi hapus dosen
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if ($this->model->delete($id)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Dosen berhasil dihapus.'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus dosen.'];
            }
        }
        header('Location: index.php?page=lecturers');
        exit;
    }

    // Sanitasi input form
    private function sanitize($post) {
        return [
            'name'           => trim($post['name'] ?? ''),
            'nidn'           => trim($post['nidn'] ?? ''),
            'email'          => trim($post['email'] ?? ''),
            'phone'          => trim($post['phone'] ?? ''),
            'specialization' => trim($post['specialization'] ?? ''),
            'join_date'      => trim($post['join_date'] ?? ''),
        ];
    }
}
