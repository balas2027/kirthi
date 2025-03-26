-- DATABASE (database.sql) --
CREATE DATABASE safe_route;
USE safe_route;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    police_id VARCHAR(50) UNIQUE,
    password VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user'
);
