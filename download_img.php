<?php

// Image URL
$imageUrl = 'https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg';

// Filename and open for writing
$filename = 'images/image' . time() . '.jpg';
$fp = fopen($filename, 'w+');

if ($fp === false) {
    echo "Failed to open file for writing.";
    exit;
}

// cURL initialize
$ch = curl_init($imageUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_FILE, $fp); // Write to file
curl_setopt($ch, CURLOPT_TIMEOUT, 20); // Max timeout
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

// Download the image
curl_exec($ch);

curl_close($ch);
fclose($fp);

echo "Image downloaded successfully and saved as: $filename";