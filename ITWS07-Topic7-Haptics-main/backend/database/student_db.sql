-- Student Management System Database
-- Run this in phpMyAdmin (XAMPP)

CREATE DATABASE IF NOT EXISTS student_management;
USE student_management;

-- Create students table (Simplified)
CREATE TABLE IF NOT EXISTS students (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    course VARCHAR(100),
    year_level VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO students (student_id, first_name, last_name, email, phone, course, year_level) VALUES
('2024-001', 'John', 'Doe', 'john.doe@email.com', '09123456789', 'Computer Science', '4th Year'),
('2024-002', 'Jane', 'Smith', 'jane.smith@email.com', '09234567890', 'Information Technology', '3rd Year'),
('2024-003', 'Mike', 'Johnson', 'mike.j@email.com', '09345678901', 'Computer Engineering', '2nd Year');

