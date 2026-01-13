-- Database initialization for Sistem Informasi Minat Generasi Muda Terhadap Jepang
-- SMK Yos Sudarso Kawunganten

CREATE DATABASE IF NOT EXISTS analisiss_jp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE analisiss_jp;

-- Users table with roles (student, admin, stakeholder)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('student', 'admin', 'stakeholder') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Student biodata table
CREATE TABLE IF NOT EXISTS biodata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nis VARCHAR(20),
    kelas VARCHAR(20),
    jurusan VARCHAR(50),
    jenis_kelamin ENUM('Laki-laki', 'Perempuan'),
    tanggal_lahir DATE,
    alamat TEXT,
    no_telepon VARCHAR(20),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Question categories (Budaya, Pendidikan, Kerja, Bahasa Jepang)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    order_num INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Questions table with Likert scale
CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    question_text TEXT NOT NULL,
    order_num INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Responses table (Likert scale: 1-5)
CREATE TABLE IF NOT EXISTS responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    question_id INT NOT NULL,
    response_value INT NOT NULL CHECK (response_value BETWEEN 1 AND 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_question (user_id, question_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default categories
INSERT INTO categories (name, description, order_num) VALUES
('Budaya Jepang', 'Pertanyaan terkait minat terhadap budaya Jepang', 1),
('Pendidikan di Jepang', 'Pertanyaan terkait minat melanjutkan pendidikan di Jepang', 2),
('Bekerja di Jepang', 'Pertanyaan terkait minat bekerja di Jepang', 3),
('Bahasa Jepang', 'Pertanyaan terkait minat belajar bahasa Jepang', 4);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, name, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');

-- Insert sample questions for each category
INSERT INTO questions (category_id, question_text, order_num) VALUES
-- Budaya Jepang
(1, 'Saya tertarik mempelajari anime dan manga dari Jepang', 1),
(1, 'Saya ingin mengenal lebih dalam tradisi dan festival Jepang', 2),
(1, 'Saya suka menonton drama dan film Jepang', 3),
(1, 'Saya tertarik dengan makanan khas Jepang', 4),
(1, 'Saya ingin mengunjungi tempat-tempat bersejarah di Jepang', 5),

-- Pendidikan di Jepang
(2, 'Saya ingin melanjutkan kuliah di universitas Jepang', 1),
(2, 'Saya tertarik dengan sistem pendidikan Jepang yang maju', 2),
(2, 'Saya ingin mendapatkan beasiswa untuk belajar di Jepang', 3),
(2, 'Saya percaya pendidikan di Jepang dapat meningkatkan karir saya', 4),
(2, 'Saya tertarik mengikuti program pertukaran pelajar ke Jepang', 5),

-- Bekerja di Jepang
(3, 'Saya tertarik bekerja di perusahaan Jepang', 1),
(3, 'Saya ingin mengikuti program magang ke Jepang', 2),
(3, 'Saya tertarik dengan budaya kerja Jepang yang disiplin', 3),
(3, 'Saya berharap dapat meningkatkan skill dengan bekerja di Jepang', 4),
(3, 'Saya tertarik dengan gaji dan fasilitas kerja di Jepang', 5),

-- Bahasa Jepang
(4, 'Saya senang belajar bahasa Jepang', 1),
(4, 'Saya aktif berlatih membaca dan menulis huruf Jepang', 2),
(4, 'Saya sering menonton konten berbahasa Jepang tanpa subtitle', 3),
(4, 'Saya ingin menguasai bahasa Jepang untuk komunikasi sehari-hari', 4),
(4, 'Saya tertarik mengikuti ujian kemampuan bahasa Jepang (JLPT)', 5);
