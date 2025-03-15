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
