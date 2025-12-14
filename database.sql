-- Create Database
CREATE DATABASE IF NOT EXISTS project;
USE project;

-- Create planetarium table
CREATE TABLE IF NOT EXISTS planetarium (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    image VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    diameter VARCHAR(50) NOT NULL,
    mass VARCHAR(50) NOT NULL,
    distance VARCHAR(100),
    temperature VARCHAR(100) NOT NULL,
    orbit_period VARCHAR(50),
    moons VARCHAR(50),
    gravity VARCHAR(50),
    day_length VARCHAR(50),
    atmosphere VARCHAR(255),
    composition VARCHAR(255),
    age VARCHAR(50),
    description LONGTEXT NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES login(userId) ON DELETE SET NULL
);

-- Create planetarium facts table
CREATE TABLE IF NOT EXISTS planetarium_facts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    planet_id INT NOT NULL,
    fact TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (planet_id) REFERENCES planetarium(id) ON DELETE CASCADE
);

-- Create quiz questions table
CREATE TABLE IF NOT EXISTS quiz_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option ENUM('A','B','C','D') NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES login(userId) ON DELETE SET NULL
);

-- Create login table
CREATE TABLE IF NOT EXISTS login (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create planet_history table
CREATE TABLE IF NOT EXISTS planet_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    planet_name VARCHAR(100) NOT NULL,
    view_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES login(userId) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_view_time (view_time)
);

-- Insert sample admin user
INSERT INTO login (email, username, password, role) 
VALUES ('admin@galaxy.com', 'admin', 'admin123', 'admin');

CREATE TABLE IF NOT EXISTS achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(16) NOT NULL UNIQUE, -- EXP, QM, STK, CMP, SPD
    title VARCHAR(64) NOT NULL,
    description VARCHAR(255) NOT NULL,
    target_label VARCHAR(128) NOT NULL,
    accent VARCHAR(16) NOT NULL DEFAULT '#8bc6ff',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS user_achievement_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    achievement_code VARCHAR(16) NOT NULL,
    progress_value DECIMAL(5,2) NOT NULL DEFAULT 0.00, -- 0.00 to 1.00
    progress_label VARCHAR(128) NOT NULL,              -- e.g., "14 / 20 kunjungan planet"
    status_label VARCHAR(64) NOT NULL,                 -- e.g., "Silver Pathfinder"
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES login(userId) ON DELETE CASCADE,
    FOREIGN KEY (achievement_code) REFERENCES achievements(code) ON DELETE CASCADE,
    UNIQUE KEY uniq_user_code (user_id, achievement_code)
);

CREATE TABLE IF NOT EXISTS quiz_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    score_percent INT NOT NULL,
    duration_seconds INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES login(userId) ON DELETE CASCADE,
    INDEX idx_user_time (user_id, created_at)
);

INSERT IGNORE INTO achievements (code, title, description, target_label, accent) VALUES
('EXP','Explorer','Kunjungi halaman planet dan baca detailnya.','Kunjungi 20 halaman planet','#ff9f43'),
('QM','Quiz Master','Selesaikan kuis dengan skor tinggi secara konsisten.','Raih 5 skor >= 80%','#7dd87d'),
('STK','Streak Keeper','Pertahankan kebiasaan belajar setiap hari.','Capai 10 hari beruntun','#6ac8ff'),
('CMP','Completionist','Tuntaskan seluruh materi utama di planetarium.','Selesaikan 20 modul','#c7a6ff'),
('SPD','Speed Learner','Selesaikan kuis cepat tanpa banyak kesalahan.','Kuasai < 50 detik, akurasi 95%','#ff89c0');
