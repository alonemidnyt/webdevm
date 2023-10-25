<?php
require_once('../db_connection.php');
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (username, password)
                VALUES ('$email',  '$password')";

    if ($con->query($sql) === TRUE) {
        header('location:../login.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn_error;
    }

    $con->close();
}
