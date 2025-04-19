<?php
require_once 'database.php';

$db = new Dbh();

$results = $db->select("
    SELECT 
        DATE(created_at) AS post_date,
        HOUR(created_at) AS post_hour,
        COUNT(*) AS post_count
    FROM posts
    WHERE is_active = 1
    GROUP BY post_date, post_hour
    ORDER BY post_date DESC, post_hour DESC
");
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

<table>
    <tr>
        <th>Date</th>
        <th>Hour</th>
        <th>Posts by hour</th>
    </tr>

    <?php foreach ($results as $row): ?>
        <tr>
            <td><?= $row['post_date'] ?></td>
            <td><?= str_pad($row['post_hour'], 2, "0", STR_PAD_LEFT) ?>:00</td>
            <td><?= $row['post_count'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
