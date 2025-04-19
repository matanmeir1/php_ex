<?php

require_once 'classes/User.php';
require_once 'classes/Post.php';
require_once 'classes/Logger.php';

try {
    $users = User::getAllWithPosts();
} catch (Exception $e) {
    Logger::logMessage("Error loading user feed: " . $e->getMessage());
    $users = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feed</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .user { border-bottom: 1px solid #ccc; margin-bottom: 20px; padding-bottom: 20px; }
        .image { width: 60px; height: 60px; border-radius: 50%; }
        .post { margin-left: 80px; margin-top: 10px; }
        .title { font-weight: bold; }
        .date { color: gray; font-size: 12px; }
    </style>
</head>
<body>

<h1>Users Feed</h1>

<?php
if (empty($users)) {
    Logger::logMessage("No users or posts found.");
} else {
    foreach ($users as $user) {
        echo "<div class='user'>";
        echo "<img src='images/image.jpg' class='image' alt='image'> ";
        echo "<strong>" . htmlspecialchars($user->name) . "</strong> (" . htmlspecialchars($user->email) . ")<br>";

        foreach ($user->posts as $post) {
            echo "<div class='post'>";
            echo "<div class='title'>" . htmlspecialchars($post->title) . "</div>";
            echo "<div class='date'>" . htmlspecialchars($post->created_at) . "</div>";
            echo "<p>" . nl2br(htmlspecialchars($post->body)) . "</p>";
            echo "</div>";
        }

        echo "</div>";
    }
}
?>

</body>
</html>
