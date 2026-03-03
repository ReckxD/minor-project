CREATE DATABASE IF NOT EXISTS civiccare;
USE civiccare;

CREATE TABLE complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    issue_type VARCHAR(50) NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255),
    status ENUM('Pending', 'In Progress', 'Resolved') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);