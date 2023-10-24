<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'connect';

// Create a database connection
$con = mysqli_connect($host, $user, $pass, $db);

if ($con) {
    echo 'Connected successfully to the database.<br>';

    // Insert sample data into the 'car_types' table with meaningful descriptions
    $sql = "INSERT INTO car_types (code, description, sold_cars) VALUES
            ('0011', 'Sedan', 10),
            ('0021', 'SUV', 15),
            ('0031', 'Hatchback', 20)";
    $query = mysqli_query($con, $sql);

    if ($query) {
        echo 'Sample data inserted successfully into "car_types" table.';
    } else {
        echo 'Error inserting data: ' . mysqli_error($con);
    }
} else {
    echo 'Connection failed: ' . mysqli_connect_error();
}
?>