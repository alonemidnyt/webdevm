
<?php
session_start();

require_once('../db_connection.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to check the credentials
    $sql = "SELECT * FROM users WHERE username = '$email' AND password = '$password'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Valid login; you can redirect to a welcome page or set a session variable
        $_POST['username'] = $username;
        header("Location: ../branch.php"); // Replace with your welcome page
        exit();
    } else {
        // Invalid login; display an error message
        echo "<script>
        if (confirm('Invalid username or password! Want to register an account?')){
            window.location.href = '../register.php';
        }else{
        window.location.href = '../login.php' }; 
        </script>";
    }
    $conn->close();
}
?>
