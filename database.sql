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

-- Insert sample regular user
INSERT INTO login (email, username, password, role) 
VALUES ('user@galaxy.com', 'user', 'user123', 'user');
