
-- Create table for students if it doesn't exist
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
);

-- Insert a sample student
INSERT INTO students (name, email, password) VALUES
('Musthafa DM', 'student@example.com', 'student123');

-- Create table for admins if it doesn't exist
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
);

-- Insert a sample admin
INSERT INTO admins (username, password) VALUES
('admin', 'admin123');
