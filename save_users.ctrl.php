<?php

require_once 'dbcon.php';
require_once 'users.obj.php';

$database = new Connection();
$db = $database->connect();

$save_user = new Users($db);

// Ensure that 'rows' is set and is an array
if (isset($_POST['rows']) && is_array($_POST['rows'])) {
    $users = $_POST['rows'];

    // Check for non-empty values and avoid inserting invalid data
    foreach ($users as $user) {
        if (
            isset($user['firstname']) && isset($user['lastname'])
            && !empty($user['firstname']) && !empty($user['lastname'])
        ) {

            $save_user->firstname = $user['firstname'];
            $save_user->lastname = $user['lastname'];

            $save = $save_user->save_users();

            // If any save fails, return 0 (failure)
            if (!$save) {
                echo 0;
                exit;  // Stop further processing
            }
        }
    }

    // If all users are saved successfully, return 1 (success)
    echo 1;
} else {
    echo 0;  // Invalid or missing data
}
