-- Create Database
CREATE DATABASE IF NOT EXISTS project;
USE project;

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
    duration_minutes INT DEFAULT 0,
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
