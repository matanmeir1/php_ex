<?php
// Downloads a default avatar image and saves it to the server.

require_once 'config.php';
require_once 'classes/Logger.php';
require_once 'classes/ApiHelper.php';


$imageUrl = 'https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg';
$filename = 'images/image.jpg';

// Fetch img from API
try {
    ApiHelper::downloadImage($imageUrl, $filename);
    Logger::logMessage("Image downloaded successfully and saved as: $filename");
} catch (Exception $e) {
    Logger::logMessage("Error downloading image: " . $e->getMessage());
}
