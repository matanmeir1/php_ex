<?php
require_once 'classes/Logger.php';


// Image URL
$imageUrl = 'https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg';

// Filename and open for writing
$filename = 'images/image.jpg';

try {
    $fp = fopen($filename, 'w+');

    if ($fp === false) {
        throw new Exception("Failed to open file for writing: $filename");
    }

    // cURL initialize
    $ch = curl_init($imageUrl);

    // Set cURL options
    curl_setopt($ch, CURLOPT_FILE, $fp); // Write to file
    curl_setopt($ch, CURLOPT_TIMEOUT, 20); // Max timeout
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

    // Download the image
    $success = curl_exec($ch);

    if (!$success) {
        throw new Exception("cURL download failed for URL: $imageUrl");
    }

    curl_close($ch);
    fclose($fp);

    Logger::logMessage("Image downloaded successfully and saved as: $filename");

} catch (Exception $e) {
    Logger::logMessage("Error downloading image: " . $e->getMessage());
}
