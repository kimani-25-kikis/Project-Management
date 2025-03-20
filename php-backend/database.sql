-- Create the database (if it doesn’t exist)
CREATE DATABASE IF NOT EXISTS project_manager;
USE project_manager;

-- Create Users Table (for login.php)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('Admin', 'Manager', 'Employee') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Projects Table (for projects_overview.php and project_details.php)
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    status ENUM('New', 'Running', 'On Hold', 'Finished') NOT NULL DEFAULT 'New',
    open_tasks INT DEFAULT 0,
    type VARCHAR(50),
    description TEXT,
    created_by VARCHAR(50) NOT NULL,
    created_date DATE NOT NULL,
    last_updated DATETIME,
    team_leader VARCHAR(50),
    priority ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
    deadline DATE NOT NULL,
    comments_count INT DEFAULT 0,
    bugs_count INT DEFAULT 0,
    messages_count INT DEFAULT 0,
    commits_count INT DEFAULT 0,
    version VARCHAR(20),
    team VARCHAR(100),
    progress INT DEFAULT 0
);

-- Create Clients Table (for project_details.php)
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    payment_status ENUM('Pending', 'Completed') DEFAULT 'Pending',
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Create Messages Table (for project_details.php)
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    sender VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    timestamp DATETIME NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Insert Sample Data
-- Users (password: 'password123')
INSERT INTO users (role, email, password) VALUES
('Admin', 'admin@example.com', '$2y$10$Xz7Q8z9k5j2m4n6p8r0t1u3v5w7x9y1z3A5B7C9D1E3F5G7H9I1J');

-- Projects (combined data from your examples)
INSERT INTO projects (name, status, open_tasks, type, description, created_by, created_date, last_updated, team_leader, priority, deadline, comments_count, bugs_count, messages_count, commits_count, version, team, progress) VALUES
('Testing', 'Running', 15, 'Website', 'Testing Michalis Add a project', 'Admin', '2024-07-31', '2024-07-31 10:00:00', 'Michael', 'Medium', '2025-04-22', 41, 11, 0, 0, NULL, '+++++++++', 50),
('Wordpress Website', 'Running', 0, 'Website', 'Lorem ipsum dolor sit amet consectetur adipisicing elit...', 'Admin', '2021-08-22', '2021-08-22 12:15:57', NULL, 'Medium', '2021-09-22', 0, 0, 277, 175, 'v2.5.2', '++++++', 50);

-- Clients
INSERT INTO clients (project_id, name, email, payment_status) VALUES
(2, 'xyx.pvt.ltd', 'xyz@gmail.com', 'Completed');

-- Messages
INSERT INTO messages (project_id, sender, content, timestamp) VALUES
(2, 'Airi Satou', 'Lorem ipsum dolor sit amet consectetur adipisicing elit...', '2025-03-19 10:00:00');