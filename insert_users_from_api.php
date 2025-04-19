<?php


require_once 'classes/User.php';
require_once 'classes/Logger.php';
require_once 'classes/ApiHelper.php';


// Fetch data from API
try {
    $users = ApiHelper::fetchJsonFromUrl("https://jsonplaceholder.typicode.com/users");
} catch (Exception $e)
{
    Logger::logMessage("Error fetching users from API: " . $e->getMessage());
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
            Logger::logMessage("Inserted user: {$userObj->name}");
        } catch (Exception $e) {
            Logger::logMessage("Failed to insert user {$userObj->name}: " . $e->getMessage());
        }
    }


