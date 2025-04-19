<?php

class ApiHelper
{
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
}
