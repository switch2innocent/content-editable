<?php
require_once 'dbcon.php';
require_once 'users.obj.php';

$database = new Connection();
$db = $database->connect();

// Instantiate the Users class
$save_user = new Users($db);

// Fetch users
$users = $save_user->display_users();
$user_data = [];

// Fetch all rows and prepare the data
while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
    $user_data[] = $row;  // Add each user to the array
}

// Return the users as a JSON response
echo json_encode($user_data);
?>
