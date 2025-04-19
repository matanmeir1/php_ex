

<?php

require_once 'classes/User.php';

function getApiData($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // אם יש הפניות
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$result) {
        return false;
    }

    return $result;
}

$url = "https://jsonplaceholder.typicode.com/users";
$json = getApiData($url);
$users = json_decode($json, true);


// Check if the API call was successful
if (!$users) {
    echo "Failed to fetch users";
    exit;
}

// Loop and insert
foreach ($users as $user) {
    $userObj = new User([
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'birth_date' => date('Y-m-d', strtotime('-' . rand(20, 40) . ' years')),
        'is_active' => 1
    ]);

    try {
        $userObj->save();
        echo "Inserted user: {$userObj->name}<br>";
    } catch (Exception $e) {
        echo "Failed to insert user {$userObj->name}: " . $e->getMessage() . "<br>";
    }
}
