<?php
// Replace with your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "webdev";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the deletion of the branch
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $branchId = $_POST["id"];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM branch WHERE id = ?");
    $stmt->bind_param("i", $branchId);

    if ($stmt->execute()) {
        echo "Branch deleted successfully.";
        // You can also perform additional actions here, such as reloading the page or updating the table
    } else {
        echo "Error deleting branch: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
