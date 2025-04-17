<?php

require_once 'database.php';

$db = new Dbh();
$conn = $db->connect();

try {
    $sqlUsers = "
        CREATE TABLE IF NOT EXISTS users (
            id INT PRIMARY KEY,
            name VARCHAR(255),
            email VARCHAR(255),
            is_active BOOLEAN DEFAULT 1,
            birth_date DATE
        );
    ";

    $conn->exec($sqlUsers);
    echo "Table 'users' created successfully.<br>";

    $sqlPosts = "
        CREATE TABLE IF NOT EXISTS posts (
            id INT PRIMARY KEY,
            user_id INT,
            title VARCHAR(255),
            body TEXT,
            created_at DATETIME,
            is_active BOOLEAN DEFAULT 1,
            FOREIGN KEY (user_id) REFERENCES users(id)
        );
    ";

    $conn->exec($sqlPosts);
    echo "Table 'posts' created successfully.<br>";

} catch (PDOException $e) {
    echo "Error creating tables: " . $e->getMessage();
}
