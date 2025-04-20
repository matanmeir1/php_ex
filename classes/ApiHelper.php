<?php

// Utility class for handling external API requests
class ApiHelper
{


    // Fetch JSON data from a given URL using cURL.
    public static function fetchJsonFromUrl($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return as string
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);           // Timeout

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if (!$response) {
            throw new Exception("cURL error: $error");
        }

        $data = json_decode($response, true);
        if ($data === null) {
            throw new Exception("Failed to decode JSON response.");
        }

        return $data;
    }


    // Download an image from a given URL and save it to a specified path.
    public static function downloadImage($url, $savePath)
    {
    $fp = fopen($savePath, 'w+');
    if ($fp === false) {
        throw new Exception("Failed to open file for writing: $savePath");
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $success = curl_exec($ch);

    if (!$success) {
        $error = curl_error($ch);
        curl_close($ch);
        fclose($fp);
        throw new Exception("cURL download failed: $error");
    }

    curl_close($ch);
    fclose($fp);
    }








}
