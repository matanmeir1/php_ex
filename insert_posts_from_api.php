<?php

require_once 'database.php';

$db = new Dbh();
$conn = $db->connect();

// Get the data from the API, turn in into strings array
$url = "https://jsonplaceholder.typicode.com/posts";
$json = file_get_contents($url);
$posts = json_decode($json, true);

if (!$posts) {
    echo "Failed to fetch posts";
    exit;
}

// Insert the data into the database
foreach ($posts as $post) 
{
    $daysAgo = rand(0, 30);
    $hour = rand(0, 23);
    $minute = rand(0, 59);
    $timestamp = mktime($hour, $minute, 0, date('m'), date('d') - $daysAgo, date('Y'));


    $data = [
        'id' => $post['id'],
        'user_id' => $post['userId'],
        'title' => $post['title'],
        'body' => $post['body'],
        'created_at' => date('Y-m-d H:i:s', $timestamp), // Random created date
        'is_active' => 1
    ];

    try {
        $db->insert("posts", $data);
        echo "Inserted post ID: {$post['id']}<br>";
    } catch (Exception $e) {
        echo "Failed to insert post ID {$post['id']}: " . $e->getMessage() . "<br>";
    }
}
