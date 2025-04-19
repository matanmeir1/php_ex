<?php

require_once 'classes/User.php';
require_once 'classes/Post.php';

$users = User::getAllWithPosts();

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
$currentUser = null;


// Loop through the results and display them
// Group posts by user
foreach ($users as $user) 
{
    echo "<div class='user'>";
    echo "<img src='images/image.jpg' class='image' alt='image'> ";
    echo "<strong>{$user->name}</strong> ({$user->email})<br>";

    foreach ($user->posts as $post) {
        echo "<div class='post'>";
        echo "<div class='title'>{$post->title}</div>";
        echo "<div class='date'>{$post->created_at}</div>";
        echo "<p>{$post->body}</p>";
        echo "</div>";
    }

    echo "</div>";
}

if ($currentUser !== null) echo "</div>";
?>

</body>
</html>
