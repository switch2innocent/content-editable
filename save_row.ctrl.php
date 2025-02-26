<?php
require_once 'dbcon.php';
require_once 'users.obj.php';

$database = new Connection();
$db = $database->connect();

// Instantiate the Users class
$save_user = new Users($db);

// Get the data from the POST request
$save_user->firstname = $_POST['firstname'];
$save_user->lastname = $_POST['lastname'];

$save = $save_user->save_users();

// Call the save function from the Users class (assuming this function inserts a user)
if ($save) {
    echo 1;  // Return 1 if save was successful
} else {
    echo 0;  // Return 0 if there was an error
}
?>
