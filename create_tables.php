<?php
// Initializes the database structure by creating the required tables


require_once 'config.php';
require_once 'classes/Database.php';
require_once 'classes/Logger.php';

// Initialize the database connection
try {
    $db = new Dbh();
    $conn = $db->connect();
} catch (Exception $e) {
    Logger::logMessage("Failed to connect to DB in create_tables.php: " . $e->getMessage());
    exit;
}

// Create the users table
try {
    //SQL to create the users table
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
    Logger::logMessage("Table 'users' created successfully.");
} catch (PDOException $e) {
    Logger::logMessage("Error creating table 'users': " . $e->getMessage());
}

// Create the posts table
try {
    //SQL to create the posts table
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
    Logger::logMessage("Table 'posts' created successfully.");
} catch (PDOException $e) {
    Logger::logMessage("Error creating table 'posts': " . $e->getMessage());
}
