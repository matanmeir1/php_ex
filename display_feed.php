<?php

require_once 'database.php';

$db = new Dbh();

//The SQL query to fetch the data
$results = $db->select("
    SELECT 
        users.id AS user_id,
        users.name AS user_name,
        users.email,
        posts.id AS post_id,
        posts.title,
        posts.body,
        posts.created_at
    FROM users
    JOIN posts ON users.id = posts.user_id
    WHERE users.is_active = 1 AND posts.is_active = 1
    ORDER BY users.id, posts.created_at DESC
");

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
foreach ($results as $row) {
    if ($currentUser !== $row['user_id']) {
        if ($currentUser !== null) echo "</div>"; // Close previous user div
        $currentUser = $row['user_id'];
        echo "<div class='user'>";
        echo "<img src='images/image.jpg' class='image' alt='image'> ";
        echo "<strong>{$row['user_name']}</strong> ({$row['email']})<br>";
    }

    echo "<div class='post'>";
    echo "<div class='title'>{$row['title']}</div>";
    echo "<div class='date'>{$row['created_at']}</div>";
    echo "<p>{$row['body']}</p>";
    echo "</div>";
}

if ($currentUser !== null) echo "</div>";
?>

</body>
</html>
