-- =============================================
-- Database Sistem Informasi Dosen & Mata Kuliah
-- =============================================
DROP DATABASE IF EXISTS tp_mvc25;
CREATE DATABASE tp_mvc25;
USE tp_mvc25;

-- Tabel dosen
CREATE TABLE lecturers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    nidn VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15),
    specialization VARCHAR(100),
    join_date DATE NOT NULL
);

-- Tabel mata kuliah
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    credits INT NOT NULL DEFAULT 2,
    semester INT NOT NULL,
    description TEXT
);

-- Tabel jadwal mengajar (relasi many-to-many antara lecturers & courses)
CREATE TABLE teaching_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lecturer_id INT NOT NULL,
    course_id INT NOT NULL,
    academic_year VARCHAR(9) NOT NULL,
    day ENUM('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    room VARCHAR(20),
    FOREIGN KEY (lecturer_id) REFERENCES lecturers(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Data awal dosen
INSERT INTO lecturers (name, nidn, email, phone, specialization, join_date) VALUES
('Dr. Budi Santoso', '0012345601', 'budi@university.ac.id', '081234567890', 'Artificial Intelligence', '2020-01-15'),
('Prof. Siti Rahayu', '0012345602', 'siti@university.ac.id', '082345678901', 'Data Science', '2018-08-01'),
('Dr. Ahmad Fauzi', '0012345603', 'ahmad@university.ac.id', '083456789012', 'Software Engineering', '2021-03-10');

-- Data awal mata kuliah
INSERT INTO courses (code, name, credits, semester, description) VALUES
('IF101', 'Pemrograman Dasar', 3, 1, 'Dasar-dasar pemrograman menggunakan bahasa C dan Python'),
('IF201', 'Basis Data', 3, 3, 'Konsep dan perancangan basis data relasional'),
('IF301', 'Kecerdasan Buatan', 3, 5, 'Pengantar AI, machine learning, dan deep learning'),
('IF202', 'Pemrograman Berorientasi Objek', 4, 3, 'Konsep OOP menggunakan Java dan PHP');

-- Data awal jadwal mengajar
INSERT INTO teaching_assignments (lecturer_id, course_id, academic_year, day, start_time, end_time, room) VALUES
(1, 3, '2026/2027', 'Senin', '08:00', '10:30', 'Lab AI-1'),
(2, 2, '2026/2027', 'Selasa', '10:00', '12:30', 'R.302'),
(3, 4, '2026/2027', 'Rabu', '13:00', '15:30', 'Lab SE-2'),
(1, 1, '2026/2027', 'Kamis', '08:00', '10:30', 'R.101');
