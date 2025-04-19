<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




require_once 'classes/Post.php';
require_once 'classes/Logger.php';
require_once 'classes/ApiHelper.php';


// Fetch data from API
try {
    $posts = ApiHelper::fetchJsonFromUrl("https://jsonplaceholder.typicode.com/posts");
} catch (Exception $e) {
    Logger::logMessage("Error fetching posts from API: " . $e->getMessage());
    exit;
}

    foreach ($posts as $post) {
        // Create a random timestamp
        $daysAgo = rand(0, 30);
        $hour = rand(0, 23);
        $minute = rand(0, 59);
        $timestamp = mktime($hour, $minute, 0, date('m'), date('d') - $daysAgo, date('Y'));

        $postObj = new Post([
            'id' => $post['id'],
            'user_id' => $post['userId'],
            'title' => $post['title'],
            'body' => $post['body'],
            'created_at' => date('Y-m-d H:i:s', $timestamp),
            'is_active' => 1
        ]);

        try {
            $postObj->save();
            Logger::logMessage("Inserted post: {$postObj->title}");
        } catch (Exception $e) {
            Logger::logMessage("Failed to insert post: " . $e->getMessage());
        }
    }

