-- 1. Create Database
CREATE DATABASE IF NOT EXISTS project_financial_tool;
USE project_financial_tool;

-- 2. Create Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'manager', 'employee') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Create Projects Table
CREATE TABLE projects (
    projectID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    department VARCHAR(100) NOT NULL,
    priority ENUM('Low', 'Medium', 'High', 'Critical') NOT NULL,
    client_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    startdate DATE NOT NULL,
    enddate DATE NOT NULL,
    team TEXT NOT NULL
);

-- 4. Create Employees Table
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    mobile VARCHAR(20) UNIQUE NOT NULL,
    joining_date DATE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    address TEXT NOT NULL
);

-- 5. Create Leave Requests Table
CREATE TABLE leave_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(100) NOT NULL,
    employee_id INT NOT NULL,
    department VARCHAR(100) NOT NULL,
    leave_type ENUM('Sick Leave', 'Casual Leave', 'Annual Leave', 'Maternity Leave', 'Paternity Leave', 'Unpaid Leave') NOT NULL,
    leave_from DATE NOT NULL,
    leave_to DATE NOT NULL,
    days INT NOT NULL,
    duration_type ENUM('Full Day', 'Half Day') NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);

-- 6. Create Holiday Table
CREATE TABLE holiday (
    id INT AUTO_INCREMENT PRIMARY KEY,
    holiday_name VARCHAR(255) NOT NULL,
    shift ENUM('Morning', 'Afternoon', 'Evening', 'Full Day') NOT NULL,
    date DATE NOT NULL,
    holiday_type ENUM('Public Holiday', 'Company Holiday', 'Special Holiday') NOT NULL,
    created_by VARCHAR(100) NOT NULL,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approval_status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    details TEXT NOT NULL
);
CREATE DATABASE holiday_manager;

USE holiday_manager;

CREATE TABLE holidays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    shift VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    type VARCHAR(50) NOT NULL,
    created_by VARCHAR(50) NOT NULL,
    creation_date DATE NOT NULL,
    approval_status ENUM('Approved', 'Pending') DEFAULT 'Pending',
    details TEXT
);
CREATE DATABASE project_manager;

USE project_manager;

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    status ENUM('Active', 'Inactive', 'Completed') NOT NULL DEFAULT 'Active',
    created_by VARCHAR(50) NOT NULL,
    last_updated DATETIME NOT NULL,
    created_date DATE NOT NULL,
    messages_count INT DEFAULT 0,
    commits_count INT DEFAULT 0,
    deadline DATE NOT NULL,
    version VARCHAR(20),
    team VARCHAR(100),
    progress INT DEFAULT 0,
    description TEXT
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    payment_status ENUM('Pending', 'Completed') DEFAULT 'Pending',
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    sender VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    timestamp DATETIME NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

-- Sample data
INSERT INTO projects (name, status, created_by, last_updated, created_date, messages_count, commits_count, deadline, version, team, progress, description) VALUES
('Wordpress Website', 'Active', 'Admin', '2021-08-22 12:15:57', '2021-08-22', 277, 175, '2021-09-22', 'v2.5.2', '++++++', 50, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur iure odio, fugiat error incidunt voluptas temporibus dolor, neque quasi corrupti quam minima iusto? Libero perspiciatis velit nostrum corporis fugit veritatis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum at unde laborum iste quos ex consectetur necessitatibus voluptate exercitationem deserunt, possimus nulla beatae maxime hic debitis eos voluptatum similique dolores. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident rerum et ut ipsum delectus est ratione sint saepe, ullam suscipit voluptas itaque quas quisquam magnam in eligendi adipisci. Sunt, libero.');


INSERT INTO clients (project_id, name, email, payment_status) VALUES
(1, 'xyx.pvt.ltd', 'xyz@gmail.com', 'Completed');

INSERT INTO messages (project_id, sender, content, timestamp) VALUES
(1, 'Airi Satou', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus assumenda, perferendis tenetur nemo quaerat commodi reprehenderit laudantium pariatur inventore ducimus.', '2025-03-19 10:00:00');

USE project_manager;

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    status ENUM('New', 'Running', 'On Hold', 'Finished') NOT NULL DEFAULT 'New',
    open_tasks INT DEFAULT 0,
    type VARCHAR(50),
    description TEXT,
    created_date DATE NOT NULL,
    team_leader VARCHAR(50),
    priority ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
    deadline DATE NOT NULL,
    comments_count INT DEFAULT 0,
    bugs_count INT DEFAULT 0,
    team VARCHAR(100),
    progress INT DEFAULT 0
);

-- Sample data
INSERT INTO projects (name, status, open_tasks, type, description, created_date, team_leader, priority, deadline, comments_count, bugs_count, team, progress) VALUES
('Testing', 'Running', 15, 'Website', 'Testing Michalis Add a project', '2024-07-31', 'Michael', 'Medium', '2025-04-22', 41, 11, '+++++++++', 50);
USE project_manager;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('Admin', 'Manager', 'Employee') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample user (password: "password123" hashed with password_hash)
INSERT INTO users (role, email, password) VALUES
('Admin', 'admin@example.com', '$2y$10$3X9Qz7z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5Z5');