# TP8DPBO2526C2 - Sistem Informasi Dosen, Mata Kuliah, & Jadwal Mengajar (Arsitektur MVC)

## Janji
Saya Muhammad Hanif Muyassar dengan NIM 2510593 mengerjakan Tugas Praktikum 8 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

---

## 1. Deskripsi Program
Proyek ini merupakan hasil refactoring dari aplikasi manajemen data dosen prosedural menjadi aplikasi berbasis arsitektur **MVC (Model-View-Controller)** menggunakan bahasa pemrograman **PHP murni (native)** dan database **MySQL** melalui koneksi **PDO (PHP Data Objects)**.

Aplikasi ini mengelola 3 entitas utama dalam lingkup akademik:
1. **Lecturers (Dosen)**: Data pengajar mencakup NIDN, Nama, Email, Nomor Telepon, Spesialisasi keahlian, dan Tanggal Bergabung.
2. **Courses (Mata Kuliah)** *(Tabel Baru 1)*: Data mata kuliah mencakup Kode MK, Nama Mata Kuliah, Bobot SKS, Semester, dan Deskripsi.
3. **Teaching Assignments (Jadwal Mengajar)** *(Tabel Baru 2)*: Relasi *many-to-many* antara Dosen dan Mata Kuliah yang mencatat penugasan mengajar, mencakup Tahun Akademik, Hari, Jam Mulai, Jam Selesai, dan Ruangan.

Setiap entitas memiliki fitur **CRUD (Create, Read, Update, Delete)** lengkap dengan validasi data dan penanganan constraint database.

---

## 2. Desain Database & Relasi

### Relasi Antar Tabel
```
lecturers (1) <──── (banyak) teaching_assignments (banyak) ────> (1) courses
```
Tabel `teaching_assignments` berfungsi sebagai tabel perantara (*junction table*) dengan relasi *foreign key* ke `lecturers(id)` dan `courses(id)` dengan opsi `ON DELETE CASCADE`.

### 1. Tabel `lecturers`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | INT, AUTO_INCREMENT | Primary Key |
| `name` | VARCHAR(100) | Nama Dosen (Wajib) |
| `nidn` | VARCHAR(20) | Nomor Induk Dosen Nasional (Wajib, Unik) |
| `email` | VARCHAR(100) | Email resmi (Unik) |
| `phone` | VARCHAR(15) | Nomor HP / WhatsApp |
| `specialization` | VARCHAR(100) | Bidang keahlian / konsentrasi |
| `join_date` | DATE | Tanggal mulai bergabung |

### 2. Tabel `courses` *(Tabel Baru)*
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | INT, AUTO_INCREMENT | Primary Key |
| `code` | VARCHAR(10) | Kode Mata Kuliah (Wajib, Unik, contoh: `IF101`) |
| `name` | VARCHAR(100) | Nama Mata Kuliah (Wajib) |
| `credits` | INT | Bobot SKS (1 - 6) |
| `semester` | INT | Rekomendasi semester (1 - 8) |
| `description` | TEXT | Deskripsi atau silabus singkat mata kuliah |

### 3. Tabel `teaching_assignments` *(Tabel Baru)*
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | INT, AUTO_INCREMENT | Primary Key |
| `lecturer_id` | INT | Foreign Key ke `lecturers(id)` |
| `course_id` | INT | Foreign Key ke `courses(id)` |
| `academic_year` | VARCHAR(9) | Tahun Akademik (contoh: `2026/2027`) |
| `day` | ENUM | Hari perkuliahan (`Senin` - `Sabtu`) |
| `start_time` | TIME | Waktu mulai perkuliahan |
| `end_time` | TIME | Waktu selesai perkuliahan |
| `room` | VARCHAR(20) | Ruang kelas atau laboratorium |

---

## 3. Arsitektur MVC (Model-View-Controller)

Pola arsitektur MVC memisahkan tanggung jawab komponen aplikasi:

```
                  ┌───────────────┐
                  │    Browser    │
                  └───────┬───────┘
                          │ 1. Request (?page=...&action=...)
                          ▼
                  ┌───────────────┐
                  │   index.php   │ (Front Controller / Router)
                  └───────┬───────┘
                          │ 2. Dispatch
                          ▼
                  ┌───────────────┐
                  │  Controllers  │ (LecturerController, CourseController, AssignmentController)
                  └───┬───────┬───┘
     3. Request data  │       │ 5. Pass data
                      ▼       ▼
              ┌─────────┐   ┌─────────┐
              │ Models  │   │  Views  │
              └────┬────┘   └────┬────┘
                   │             │
        4. Query   ▼             │ 6. Render HTML
              ┌─────────┐        ▼
              │ Database│   ┌───────────────┐
              └─────────┘   │    Browser    │
                            └───────────────┘
```

1. **Model (`Project/models/`)**:
   - `Lecturer.php`: Mengelola operasi CRUD tabel `lecturers`.
   - `Course.php`: Mengelola operasi CRUD tabel `courses`.
   - `TeachingAssignment.php`: Mengelola operasi CRUD tabel `teaching_assignments`, termasuk query `JOIN` untuk menampilkan nama dosen dan mata kuliah.

2. **View (`Project/views/`)**:
   - `layouts/header.php` & `layouts/footer.php`: Template navigasi, bootstrap, notifikasi alert flash message, dan layout konsisten.
   - `lecturers/`: Halaman `index.php` (tabel dosen), `create.php` (form tambah), dan `edit.php` (form edit).
   - `courses/`: Halaman `index.php` (tabel mata kuliah), `create.php`, dan `edit.php`.
   - `assignments/`: Halaman `index.php` (tabel jadwal), `create.php` (pilihan dropdown dosen dan mata kuliah), dan `edit.php`.

3. **Controller (`Project/controllers/`)**:
   - `LecturerController.php`: Menangani request routing dosen (index, create, edit, delete), validasi input, sanitasi, dan flash session.
   - `CourseController.php`: Menangani request mata kuliah, validasi SKS & semester, dan flash session.
   - `AssignmentController.php`: Menangani relasi jadwal, validasi waktu (start time < end time), dan integritas foreign key.

4. **Front Controller / Router (`Project/index.php`)**:
   - Menerima semua HTTP request dan mendistribusikan ke Controller dan Action yang sesuai berdasarkan parameter query string `?page=...&action=...`.

---

## 4. Struktur Repository

Sesuai ketentuan tugas praktikum:
```
TP8DPBO2526C2/
├── Project/                   # Folder project berarsitektur MVC
│   ├── config/
│   │   └── database.php       # Inisialisasi koneksi PDO ke MySQL
│   ├── controllers/
│   │   ├── LecturerController.php
│   │   ├── CourseController.php
│   │   └── AssignmentController.php
│   ├── models/
│   │   ├── Lecturer.php
│   │   ├── Course.php
│   │   └── TeachingAssignment.php
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── header.php
│   │   │   └── footer.php
│   │   ├── lecturers/
│   │   │   ├── index.php
│   │   │   ├── create.php
│   │   │   └── edit.php
│   │   ├── courses/
│   │   │   ├── index.php
│   │   │   ├── create.php
│   │   │   └── edit.php
│   │   └── assignments/
│   │       ├── index.php
│   │       ├── create.php
│   │       └── edit.php
│   ├── public/
│   │   ├── css/
│   │   │   ├── bootstrap.min.css
│   │   │   └── style.css
│   │   └── js/
│   │       └── bootstrap.bundle.min.js
│   └── index.php              # Entry point utama MVC
├── Dokumentasi/               # Folder dokumentasi (screenshot / screen record)
├── tp_mvc25.sql               # File SQL database & seed data
├── index.php                  # Redirector ke Project/index.php
└── README.md                  # Dokumentasi lengkap proyek
```

---

## 5. Fitur Keamanan & Best Practices
- **Prepared Statements (PDO):** Menghindari kerentanan SQL Injection pada seluruh operasi query.
- **XSS Prevention:** Seluruh data yang ditampilkan ke antarmuka pengguna di-escape menggunakan `htmlspecialchars()`.
- **Post/Redirect/Get (PRG) Pattern:** Mencegah pengiriman form berulang (*duplicate form submission*) saat pengguna me-refresh halaman.
- **Foreign Key Integrity:** Menjamin relasi antara jadwal mengajar, dosen, dan mata kuliah tetap sinkron dengan `ON DELETE CASCADE`.

---

## 7. Dokumentasi




https://github.com/user-attachments/assets/ae301060-9bad-473f-9822-e1c8509036d7




