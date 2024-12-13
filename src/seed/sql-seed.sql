CREATE TABLE List (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL
);

CREATE TABLE Task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL,
    description VARCHAR(255) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    is_completed BIT(1),
    list_id INT,
    FOREIGN KEY (list_id) REFERENCES List(id)
);