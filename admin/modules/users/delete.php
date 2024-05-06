<?php
session_start();
$id = $_POST['id'];

require_once '../../config.php';

$query_users = "DELETE FROM `Users` WHERE id='" . $id . "'";
$query_account = "DELETE FROM `Account` WHERE id='" . $id . "'";

if ($link->query($query_users) === TRUE) {
    if ($link->query($query_account) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error: " . $query_account . "<br>" . $link->error;
    }
} else {
    echo "Error: " . $query_users . "<br>" . $link->error;
}
