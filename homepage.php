<?php

// Main entry point and dashboard for the project.


require_once 'config.php';
require_once 'classes/Logger.php';

function safeInclude($file, $label) {
    try {
        require_once $file;
        Logger::logMessage("$label completed successfully.");
    } catch (Exception $e) {
        Logger::logMessage("$label failed: " . $e->getMessage());
    }
}

Logger::logMessage("\n=== Starting project initialization ===");

safeInclude('create_tables.php', 'Create tables');
safeInclude('download_img.php', 'Download image');
safeInclude('insert_users_from_api.php', 'Insert users');
safeInclude('insert_posts_from_api.php', 'Insert posts');

Logger::logMessage("=== Initialization complete ===\n");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Homepage</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 40px; background-color: #f5f5f5; }
        h1 { margin-bottom: 30px; }
        a.button {
            display: inline-block;
            margin: 10px;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
        a.button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Project Homepage</h1>

<a class="button" href="display_feed.php">Users Feed</a>
<a class="button" href="display_birthday_posts.php">Birthday Feed</a>
<a class="button" href="posts_by_hour.php">Posts by Hour</a>
<a class="button" href="logs/app.log" target="_blank">View Log File</a>

<br><br>
<p style="font-size: 14px; color: #555;">
    Built for inManage — see <a href="why_me.php">why I might be a good fit</a>
</p>

</body>
</html>
