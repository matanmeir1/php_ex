<?php
// Displays the latest post from each active user whose birthday is this month.



require_once 'classes/Post.php';
require_once 'classes/Logger.php';

try {
    $results = Post::getBirthdayFeed();
} catch (Exception $e) {
    Logger::logMessage("Error loading birthday feed: " . $e->getMessage());
    $results = [];
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

<h1>Birthday Users Last Post</h1>

<a class="button" href="homepage.php">Back to Homapage</a><br>

<?php
if (empty($results)) {
    echo "<p>No results found.</p>";
} else {
    $currentUser = null;

    // Group posts by user
    foreach ($results as $row) {
        if ($currentUser !== $row['user_id']) {
            if ($currentUser !== null) echo "</div>"; // Close previous user div
            $currentUser = $row['user_id'];
            echo "<div class='user'>";
            echo "<img src='images/image.jpg' class='image' alt='image'> ";
            echo "<strong>" . htmlspecialchars($row['user_name']) . "</strong> (" . htmlspecialchars($row['email']) . ")<br>";
        }

        echo "<div class='post'>";
        echo "<div class='title'>" . htmlspecialchars($row['title']) . "</div>";
        echo "<div class='date'>" . htmlspecialchars($row['created_at']) . "</div>";
        echo "<p>" . nl2br(htmlspecialchars($row['body'])) . "</p>";
        echo "</div>";
    }

    if ($currentUser !== null) echo "</div>";
}
?>
<a class="button" href="homepage.php">Back to Homapage</a><br>

</body>
</html>
