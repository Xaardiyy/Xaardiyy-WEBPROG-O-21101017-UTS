CREATE DATABASE uts_project;
USE uts_project;

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    author VARCHAR(100),
    STATUS VARCHAR(50),
    rating INT,
    notes TEXT,
    file_path VARCHAR(255),
    file_type VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
