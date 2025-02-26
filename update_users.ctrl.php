<?php

require_once 'dbcon.php';
require_once 'users.obj.php';

$database = new Connection();
$db = $database->connect();

$update_user = new Users($db);

$update_user->firstname = $_POST['firstname'];
$update_user->lastname = $_POST['lastname'];
$update_user->id = $_POST['id'];

$update = $update_user->update_users();

if ($update) {
    echo 1;
} else {
    echo 0;
}
?>