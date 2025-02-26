<?php

require_once 'dbcon.php';
require_once 'users.obj.php';

$database = new Connection();
$db = $database->connect();

$delete_user = new Users($db);

$delete_user->id = $_POST['id'];

$delete = $delete_user->delete_users();

if ($delete) {
    echo 1;
} else {
    echo 0;
}

?>