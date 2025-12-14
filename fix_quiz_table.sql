-- Fix for quiz_questions table - add missing correct_option column
-- Run this in phpMyAdmin or MySQL command line

USE project;

-- Check if column exists and add it if it doesn't
ALTER TABLE quiz_questions 
ADD COLUMN correct_option ENUM('A','B','C','D') NOT NULL 
AFTER option_d;

-- If you get an error that the column already exists, the table is fine
-- If you get an error about missing table, run database.sql first
