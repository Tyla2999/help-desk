CREATE DATABASE IF NOT EXISTS help_desk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE help_desk;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'supervisor', 'staff') NOT NULL DEFAULT 'staff',
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS announcements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    detail TEXT NOT NULL,
    image_url VARCHAR(500) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS tickets (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    department VARCHAR(150) NULL,
    problem TEXT NOT NULL,
    priority ENUM('ต่ำ', 'ปกติ', 'สูง', 'เร่งด่วน') NOT NULL DEFAULT 'ปกติ',
    status VARCHAR(50) NOT NULL DEFAULT 'ใหม่',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS site_contents (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content_key VARCHAR(120) NOT NULL UNIQUE,
    content_value TEXT NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS employee_ideas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(120) NOT NULL,
    description VARCHAR(500) NOT NULL,
    vote_count INT UNSIGNED NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    CONSTRAINT fk_employee_ideas_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (full_name, email, password_hash, role, status, created_at, updated_at)
SELECT 'System Admin', 'admin@helpdesk.local', '$2y$10$geQAlqOlLZtsikZ5m1Hh7uS9ybx9nQEGWZzQahay4lgraCN2xXc46', 'admin', 'approved', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'admin@helpdesk.local');

INSERT INTO site_contents (content_key, content_value, updated_at)
VALUES
    ('hero_title', 'บริการไอทีครบวงจร เพื่อการทำงานที่มีประสิทธิภาพ', NOW()),
    ('hero_subtitle', 'ศูนย์กลางข้อมูลข่าวสาร บริการ และการสนับสนุนด้านเทคโนโลยีสารสนเทศ สำหรับบุคลากรทุกท่าน', NOW()),
    ('contact_phone', '0-2xxx-xxxx ต่อ 1234', NOW()),
    ('contact_email', 'it@company.com', NOW())
ON DUPLICATE KEY UPDATE content_value = VALUES(content_value), updated_at = VALUES(updated_at);
