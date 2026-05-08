-- ==========================================================
-- Seventh-day Adventist Church Management System Database 
-- ==========================================================
-- Note: Run this script to create the tables and insert sample data.

CREATE DATABASE IF NOT EXISTS sda_church_db;
USE sda_church_db;

-- 1. users: System administrators, pastors, clerks, and treasurers
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE,
    role ENUM('admin', 'pastor', 'clerk', 'treasurer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. members: Church members database
CREATE TABLE IF NOT EXISTS members (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE,
    gender ENUM('Male', 'Female') NOT NULL,
    contact_number VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    baptism_date DATE,
    status ENUM('Active', 'Inactive', 'Transferred', 'Deceased') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 3. departments: Church ministries and departments
CREATE TABLE IF NOT EXISTS departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. member_departments: Many-to-many relationship mapping members to departments
CREATE TABLE IF NOT EXISTS member_departments (
    member_id INT,
    department_id INT,
    role VARCHAR(50) DEFAULT 'Member', -- e.g., 'Leader', 'Secretary', 'Member'
    joined_date DATE,
    PRIMARY KEY (member_id, department_id),
    FOREIGN KEY (member_id) REFERENCES members(member_id) ON DELETE CASCADE,
    FOREIGN KEY (department_id) REFERENCES departments(department_id) ON DELETE CASCADE
);

-- 5. tithes: Track tithes returned by members
CREATE TABLE IF NOT EXISTS tithes (
    tithe_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    amount DECIMAL(10,2) NOT NULL,
    date_received DATE NOT NULL,
    receipt_number VARCHAR(50) UNIQUE,
    recorded_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(member_id) ON DELETE SET NULL,
    FOREIGN KEY (recorded_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 6. offerings: Track offerings (can be general or specific categories)
CREATE TABLE IF NOT EXISTS offerings (
    offering_id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(75) NOT NULL, -- e.g., 'Sabbath School', 'Church Budget', 'Camp Meeting'
    amount DECIMAL(10,2) NOT NULL,
    date_received DATE NOT NULL,
    recorded_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recorded_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 7. donations: Special projects or funds (Building fund, Pathfinder camporee, etc.)
CREATE TABLE IF NOT EXISTS donations (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NULL, -- Can be anonymous if NULL
    purpose VARCHAR(100) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    date_received DATE NOT NULL,
    receipt_number VARCHAR(50),
    recorded_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(member_id) ON DELETE SET NULL,
    FOREIGN KEY (recorded_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 8. baptisms: Records of baptisms
CREATE TABLE IF NOT EXISTS baptisms (
    baptism_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    baptism_date DATE NOT NULL,
    pastor_name VARCHAR(100) NOT NULL,
    location VARCHAR(150),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(member_id) ON DELETE CASCADE
);

-- 9. transfers: Member transfers between churches
CREATE TABLE IF NOT EXISTS transfers (
    transfer_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    transfer_type ENUM('In', 'Out') NOT NULL,
    from_church VARCHAR(150),
    to_church VARCHAR(150),
    request_date DATE NOT NULL,
    approval_date DATE NULL,
    status ENUM('Pending', 'Approved', 'Completed', 'Rejected') DEFAULT 'Pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(member_id) ON DELETE CASCADE
);

-- 10. documents: Church records, board minutes, policies
CREATE TABLE IF NOT EXISTS documents (
    document_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    uploaded_by INT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 11. announcements: Church bulletin and announcements
CREATE TABLE IF NOT EXISTS announcements (
    announcement_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    content TEXT NOT NULL,
    publish_date DATE NOT NULL,
    expiry_date DATE NULL,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 12. activity_logs: Audit trail for system security and tracking
CREATE TABLE IF NOT EXISTS activity_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- ==========================================================
-- Insert Sample Records for Testing
-- ==========================================================

-- System Users
INSERT INTO users (username, password_hash, first_name, last_name, email, role) VALUES
('admin_user', 'hashedpassword123', 'System', 'Admin', 'admin@sdachurch.com', 'admin'),
('pastor_john', 'hashedpassword123', 'John', 'Smith', 'pastor@sdachurch.com', 'pastor'),
('clerk_jane', 'hashedpassword123', 'Jane', 'Doe', 'clerk@sdachurch.com', 'clerk'),
('treasurer_mike', 'hashedpassword123', 'Mike', 'Johnson', 'treasurer@sdachurch.com', 'treasurer');

-- Church Members
INSERT INTO members (first_name, last_name, date_of_birth, gender, contact_number, email, address, baptism_date, status) VALUES
('Alice', 'Williams', '1985-04-12', 'Female', '555-0101', 'alice@email.com', '123 Elm St, City', '2000-05-20', 'Active'),
('Bob', 'Brown', '1990-08-25', 'Male', '555-0102', 'bob@email.com', '456 Oak Ave, City', '2010-09-15', 'Active'),
('Charlie', 'Davis', '1975-11-03', 'Male', '555-0103', 'charlie@email.com', '789 Pine Rd, City', '1995-12-01', 'Transferred');

-- Departments
INSERT INTO departments (name, description) VALUES
('Sabbath School', 'Oversees Sabbath School study classes and materials'),
('Youth Ministry & Pathfinders', 'Engaging young people and Pathfinder clubs'),
('Womens Ministries', 'Uplifting women in the church community'),
('Personal Ministries', 'Evangelism and outreach programs');

-- Member Departments (Assignments)
INSERT INTO member_departments (member_id, department_id, role, joined_date) VALUES
(1, 1, 'Superintendent', '2023-01-01'),
(1, 4, 'Member', '2023-01-15'),
(2, 2, 'Pathfinder Director', '2022-06-10');

-- Tithes
-- Assuming user_id 4 is the treasurer
INSERT INTO tithes (member_id, amount, date_received, receipt_number, recorded_by) VALUES
(1, 250.00, '2024-03-02', 'TR-1001', 4),
(2, 100.00, '2024-03-02', 'TR-1002', 4);

-- Offerings
INSERT INTO offerings (category, amount, date_received, recorded_by) VALUES
('Sabbath School', 145.50, '2024-03-02', 4),
('Church Budget', 320.00, '2024-03-02', 4),
('Conference Advance', 85.00, '2024-03-02', 4);

-- Donations
INSERT INTO donations (member_id, purpose, amount, date_received, receipt_number, recorded_by) VALUES
(1, 'Church Building Fund', 500.00, '2024-03-02', 'DR-2001', 4),
(NULL, 'Evangelism Subsidies', 150.00, '2024-03-02', 'DR-2002', 4);

-- Baptisms
INSERT INTO baptisms (member_id, baptism_date, pastor_name, location, notes) VALUES
(1, '2000-05-20', 'Pr. David Miller', 'Main Sanctuary Pool', 'Sabbath afternoon baptism'),
(2, '2010-09-15', 'Pr. Samuel Wilson', 'Camp Meeting Lake', 'Annual camp meeting baptism');

-- Transfers
-- Charlie Davis is transferring out
INSERT INTO transfers (member_id, transfer_type, to_church, request_date, approval_date, status, notes) VALUES
(3, 'Out', 'Sunrise SDA Church', '2024-02-10', '2024-02-28', 'Approved', 'Moved to a new city for work');

-- Documents
-- Assuming user_id 3 is the clerk
INSERT INTO documents (title, description, file_path, uploaded_by) VALUES
('Church Board Minutes - Jan 2024', 'Minutes from the January board meeting', '/uploads/docs/board_jan_2024.pdf', 3),
('Sabbath School Policy 2024', 'Updated guidelines for SS classes', '/uploads/docs/ss_policy_2024.pdf', 3);

-- Announcements
INSERT INTO announcements (title, content, publish_date, expiry_date, created_by) VALUES
('Communion Sabbath', 'Next Sabbath will be Communion. Please prepare your hearts.', '2024-03-01', '2024-03-10', 3),
('Youth Choir Practice', 'Practice is moved to Sunday at 4 PM.', '2024-03-03', '2024-03-05', 3);

-- Activity Logs
INSERT INTO activity_logs (user_id, action, description, ip_address) VALUES
(1, 'Login', 'Admin logged into the system', '192.168.1.100'),
(4, 'Add Tithe', 'Recorded tithe for member 1', '192.168.1.105'),
(3, 'Approve Transfer', 'Approved transfer out for member 3', '192.168.1.102');
