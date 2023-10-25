    <?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "webdev";

    // Create a database connection
    $con = new mysqli($server, $username, $password, $database);

    // Check the connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    ?>
