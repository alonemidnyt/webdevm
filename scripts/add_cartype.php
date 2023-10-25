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
    $cartypeCode = $_POST["carTypeCode"];
    $cartypeName = $_POST["carTypeName"];
    $branchId = $_POST["branchId"];
    $totalCarsSold = 0;

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO cartypes (code, description, total_car_sold, branch) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $cartypeCode, $cartypeName, $totalCarsSold, $branchId);

    if ($stmt->execute()) {
        echo "Car type added successfully.";
    } else {
        echo "Error adding branch: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
