-- ================================================
-- Database: project
-- Galaxy Explorer - Praktikum Pemrograman Web
-- ================================================
-- Note: Database harus sudah dibuat di hosting
-- Script ini hanya membuat tabel-tabel yang diperlukan

-- ================================================
-- Table: login
-- Purpose: Menyimpan data user dan admin
-- ================================================
CREATE TABLE IF NOT EXISTS `login` (
  `userId` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `unique_username` (`username`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Table: planetarium
-- Purpose: Menyimpan data planet dan informasinya
-- ================================================
CREATE TABLE IF NOT EXISTS `planetarium` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `type` VARCHAR(50) DEFAULT NULL,
  `diameter` VARCHAR(100) DEFAULT NULL,
  `mass` VARCHAR(100) DEFAULT NULL,
  `distance` VARCHAR(100) DEFAULT NULL,
  `temperature` VARCHAR(100) DEFAULT NULL,
  `orbit_period` VARCHAR(100) DEFAULT NULL,
  `moons` VARCHAR(50) DEFAULT NULL,
  `gravity` VARCHAR(100) DEFAULT NULL,
  `day_length` VARCHAR(100) DEFAULT NULL,
  `atmosphere` TEXT DEFAULT NULL,
  `composition` TEXT DEFAULT NULL,
  `age` VARCHAR(100) DEFAULT NULL,
  `description` TEXT NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_by` INT(11) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_is_active` (`is_active`),
  KEY `fk_planetarium_created_by` (`created_by`),
  CONSTRAINT `fk_planetarium_created_by` FOREIGN KEY (`created_by`) REFERENCES `login` (`userId`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Table: planetarium_facts
-- Purpose: Menyimpan fakta-fakta menarik tentang planet
-- ================================================
CREATE TABLE IF NOT EXISTS `planetarium_facts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `planet_id` INT(11) NOT NULL,
  `fact` TEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_facts_planet_id` (`planet_id`),
  CONSTRAINT `fk_facts_planet_id` FOREIGN KEY (`planet_id`) REFERENCES `planetarium` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Table: quiz_questions
-- Purpose: Menyimpan soal-soal quiz
-- ================================================
CREATE TABLE IF NOT EXISTS `quiz_questions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `question` TEXT NOT NULL,
  `option_a` VARCHAR(255) NOT NULL,
  `option_b` VARCHAR(255) NOT NULL,
  `option_c` VARCHAR(255) NOT NULL,
  `option_d` VARCHAR(255) NOT NULL,
  `correct_option` ENUM('A', 'B', 'C', 'D') NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Table: quiz_results
-- Purpose: Menyimpan hasil quiz user
-- ================================================
CREATE TABLE IF NOT EXISTS `quiz_results` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `score_percent` INT(11) NOT NULL,
  `duration_seconds` INT(11) DEFAULT NULL,
  `completed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_quiz_results_user_id` (`user_id`),
  KEY `idx_score` (`score_percent`),
  KEY `idx_completed_at` (`completed_at`),
  CONSTRAINT `fk_quiz_results_user_id` FOREIGN KEY (`user_id`) REFERENCES `login` (`userId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Table: planet_history
-- Purpose: Menyimpan riwayat kunjungan user ke halaman planet
-- ================================================
CREATE TABLE IF NOT EXISTS `planet_history` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `planet_name` VARCHAR(100) NOT NULL,
  `view_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_planet_history_user_id` (`user_id`),
  KEY `idx_planet_name` (`planet_name`),
  KEY `idx_view_time` (`view_time`),
  CONSTRAINT `fk_planet_history_user_id` FOREIGN KEY (`user_id`) REFERENCES `login` (`userId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Table: achievements
-- Purpose: Menyimpan daftar achievements yang tersedia
-- ================================================
CREATE TABLE IF NOT EXISTS `achievements` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `target_label` VARCHAR(100) DEFAULT NULL,
  `accent` VARCHAR(50) DEFAULT 'blue',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_code` (`code`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Table: user_achievement_progress
-- Purpose: Menyimpan progress achievement setiap user
-- ================================================
CREATE TABLE IF NOT EXISTS `user_achievement_progress` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `achievement_code` VARCHAR(10) NOT NULL,
  `progress_value` DECIMAL(5,4) NOT NULL DEFAULT 0.0000,
  `progress_label` VARCHAR(100) DEFAULT NULL,
  `status_label` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_achievement` (`user_id`, `achievement_code`),
  KEY `fk_progress_achievement_code` (`achievement_code`),
  CONSTRAINT `fk_progress_user_id` FOREIGN KEY (`user_id`) REFERENCES `login` (`userId`) ON DELETE CASCADE,
  CONSTRAINT `fk_progress_achievement_code` FOREIGN KEY (`achievement_code`) REFERENCES `achievements` (`code`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- Table: announcements
-- Purpose: Menyimpan pengumuman dari admin
-- ================================================
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) DEFAULT NULL,
  `content` TEXT NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `start_at` TIMESTAMP NULL DEFAULT NULL,
  `end_at` TIMESTAMP NULL DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_start_end` (`start_at`, `end_at`),
  KEY `fk_announcements_created_by` (`created_by`),
  CONSTRAINT `fk_announcements_created_by` FOREIGN KEY (`created_by`) REFERENCES `login` (`userId`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================
-- END OF DATABASE SCHEMA
-- ================================================
