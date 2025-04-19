<?php

require_once 'classes/Post.php';


function getApiData($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$result) {
        return false;
    }

    return $result;
}

$json = getApiData("https://jsonplaceholder.typicode.com/posts");
$posts = json_decode($json, true);







// $url = "https://jsonplaceholder.typicode.com/posts";
// $json = file_get_contents($url);
// $posts = json_decode($json, true);

if (!$posts)
{
    echo "Failed to fetch posts";
    exit;
}

foreach ($posts as $post) {
    // Create a random timest
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
        echo "Inserted post: {$postObj->title}<br>";
    } catch (Exception $e) {
        echo "Failed to insert post: " . $e->getMessage() . "<br>";
    }
}
