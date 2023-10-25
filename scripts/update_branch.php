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

// Handle the update of a branch
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $branchId = intval($_POST["id"]);
    $newBranchName = $_POST["name"];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE branch SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $newBranchName, $branchId);

    if ($stmt->execute()) {
        echo "Branch updated successfully.";
    } else {
        echo "Error updating branch: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
