<?php

require_once 'database.php';

$db = new Dbh();
$conn = $db->connect();

// Get the data from the API, turn in into strings array
$url = "https://jsonplaceholder.typicode.com/users";
$json = file_get_contents($url);
$users = json_decode($json, true);

if (!$users) {
    echo "Failed to fetch users";
    exit;
}

// Insert the data into the database
foreach ($users as $user) 
{
    $data = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'is_active' => 1,
        'birth_date' => date('Y-m-d', strtotime('-' . rand(20, 40) . ' years')) // Random birthday for question 6
    ];

    try {
        $db->insert("users", $data);
        echo "Inserted user: {$user['name']}<br>";
    } catch (Exception $e) {
        echo "Failed to insert user {$user['name']}: " . $e->getMessage() . "<br>";
    }
}
