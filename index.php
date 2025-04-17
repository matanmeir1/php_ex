<?php

include 'database.php';

$object = new Dbh();
$object->connect();


// $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hash')";

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action = "<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method = "post">
    <h2> Login Form</h2>
    <p> Please enter your username and password</p>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br><br>
    <input type="submit" value="Submit" value = "register">


</form>

<?php

$object = new Dbh();
$object->connect();



?>

</body>
</html>


<?php

if($_SERVER["REQUEST_METHOD"]== "POST")
{
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

if(empty($username) || empty($password))
{
    echo "Please fill in all fields";
}


else
{
    $hash = password_hash($password, PASSWORD_DEFAULT);
    try {
        $sql = "INSERT INTO users (user, password) VALUES (:username, :password)";
        $stmt = $object->Connect()->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hash);

        // Execute the query and check if the insertion was successful
        if ($stmt->execute()) {
            echo "<br><br> User registered successfully";
        } else {
            echo "Error: " . implode(":", $stmt->errorInfo()); // If there's an error with the query
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
}
}
}

// Close the connection
?>
