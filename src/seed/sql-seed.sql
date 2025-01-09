CREATE DATABASE IF NOT EXISTS todolist;

USE todolist;

CREATE TABLE List (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS Task (
    id INT AUTO_INCREMENT,
    title VARCHAR(30) NOT NULL,
    description VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_completed BIT(1) NOT NULL DEFAULT 0,
    list_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (list_id) REFERENCES List(id)
);