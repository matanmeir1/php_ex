<?php
include 'database.php';

$db = new Dbh();

echo "<h2>--- START TESTING DB ---</h2>";

//
// 1. SELECT בסיסי
//
echo "<h3>1. SELECT * FROM users</h3>";
$users = $db->select("SELECT * FROM users");
foreach ($users as $user) {
    echo "User: {$user['user']} | ID: {$user['id']}<br>";
}

// //
// // 2. INSERT משתמש חדש
// //
// echo "<h3>2. INSERT NEW USER</h3>";
// $newUser = 'user_' . rand(100, 999);
// $data = [
//     'user' => $newUser,
//     'password' => password_hash('123456', PASSWORD_DEFAULT),
//     'reg_date' => date('Y-m-d H:i:s')
// ];
// $db->insert('users', $data);
// echo "Inserted new user: $newUser<br>";

// //
// // 3. SELECT עם WHERE
// //
// echo "<h3>3. SELECT WHERE user = '$newUser'</h3>";
// $result = $db->select("SELECT * FROM users WHERE user = :user", ['user' => $newUser]);
// print_r($result);

// //
// // 4. UPDATE שם משתמש
// //
// echo "<h3>4. UPDATE user → {$newUser}_updated</h3>";
// $db->update('users', ['user' => $newUser . '_updated'], "user = '$newUser'");
// echo "Updated username<br>";

//
// 5. DELETE משתמש
//
echo "<h3>5. DELETE user</h3>";
$usernameToDelete = 'matan';
$deleted = $db->delete("users", "user = :username", ['username' => $usernameToDelete]);
echo "Deleted user<br>";

// //
// // 6. SELECT עם ORDER BY
// //
// echo "<h3>6. SELECT ORDER BY id DESC</h3>";
// $ordered = $db->select("SELECT * FROM users ORDER BY id DESC LIMIT 5");
// foreach ($ordered as $row) {
//     echo "User: {$row['user']} | ID: {$row['id']}<br>";
// }
// //