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

// Handle the insertion of a new branch
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $branchName = $_POST["branchName"];
    $totalCarsSold = 0;

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO branch (name, total_car_sold) VALUES (?, ?)");
    $stmt->bind_param("si", $branchName, $totalCarsSold);

    if ($stmt->execute()) {
        echo "Branch added successfully.";
    } else {
        echo "Error adding branch: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
