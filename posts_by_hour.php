<?php
// Displays a table summarizing post activity by date and hour

require_once 'classes/Post.php';
require_once 'classes/Logger.php';

// The method to fetch the data
try {
    $results = Post::getGroupedByHour();

    if (empty($results)) {
        Logger::logMessage("No grouped post data found.");
    }

} catch (Exception $e) {
    Logger::logMessage("Error fetching posts by hour: " . $e->getMessage());
    $results = [];
}
?>

<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <title>Posts by hour</title>
    <style>
        table { border-collapse: collapse; width: 60%; margin: 20px auto; direction: rtl; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: center; }
        th { background-color: #f2f2f2; }
        body { font-family: sans-serif; }
    </style>
</head>
<body>

<h2 style="text-align: center;">Posts by hour</h2>

<a class="button" href="homepage.php">Back to Homapage</a><br>

<table>
    <tr>
        <th>Date</th>
        <th>Hour</th>
        <th>Posts by hour</th>
    </tr>

    <?php
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['post_date']) . "</td>";
        echo "<td>" . str_pad($row['post_hour'], 2, "0", STR_PAD_LEFT) . ":00</td>";
        echo "<td>" . htmlspecialchars($row['post_count']) . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<a class="button" href="homepage.php">Back to Homapage</a><br>


</body>
</html>
