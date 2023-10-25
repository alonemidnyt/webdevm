<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Type</title>
    <link rel="stylesheet" type="text/css" href="./styles/cartype.css">
</head>
<body>
<h2>Car Type</h2>
<button id="addTypeButton" onclick="showAddForm()" style="margin-bottom: 10px">Add Car Type</button>
 <!-- Form for adding a new branch (initially hidden) -->
        <div id="addForm" style="display: none; margin-bottom: 10px;">
            <h3>Add Car Type</h3>
            <form id="cartypeForm">
                <label for="cartypeCode">Car Type Code:</label>
                <input type="text" id="carTypeCode" name="carTypeCode" required>
                <label for="cartypeName">Car Type Name:</label>
                <input type="text" id="carTypeName" name="carTypeName" required>    
                <button type="button" onclick="addCartype()">Add</button>
                <button type="button" onclick="hideTypeButton()">Cancel</button>
            </form>
        </div>


<table>
    <thead>
        <tr>
            <th>Description</th>
            <th>Total Cars Sold</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_GET['id'])) {
            $branchId = $_GET['id'];

            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "webdev";

            // Create a connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch data based on the condition
            $sql = "SELECT description, total_car_sold FROM cartypes WHERE branch = $branchId";

            // Execute the query
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                        <td>' . $row['description'] . '</td>
                        <td>' . $row['total_car_sold'] . '</td>
                        <td>
                        <button class="view-button">Products</button>
                        <button class="delete-button">Delete</button>
                        </td>
                    </tr>';

                }
            } else {
                echo '<tr><td colspan="2">No results found.</td></tr>';
            }

            $conn->close();
        } else {
            echo '<tr><td colspan="2">No branch ID provided.</td></tr>';
        }
        ?>
    </tbody>
</table>

<script>

    // Function to get query parameters from the URL
    function getQueryParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

    // JavaScript functions to handle button actions and form visibility
    function showAddForm() {
            document.getElementById("addForm").style.display = "block";
            const button=document.getElementById("addTypeButton");
            button.style.display = "none"
    }

    function hideTypeButton() {
            document.getElementById("addForm").style.display = "none";
            const button=document.getElementById("addTypeButton");
            button.style.display = "inline"
        }

    function addCartype() {
    

            // Get form data
            let cartypeCode = document.getElementById("carTypeCode").value;
            let cartypeName = document.getElementById("carTypeName").value;
            let branchId = getQueryParameter('id');

            // Validate form data (add your own validation logic here)
            if (!cartypeCode) {
                alert("Please fill out all fields.");
                return;
            }

            if (!cartypeName) {
                alert("Please fill out all fields.");
                return;
            }

            // Send an AJAX request to add the branch
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("Car Type added successfully.");
                    // Reload the page after adding a new branch
                    location.reload();
                }
            };
            xhr.open("POST", "./scripts/add_cartype.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("carTypeCode=" + cartypeCode + "&carTypeName=" + cartypeName + "&branchId=" + branchId);

    }

        
</script>

</body>
</html>
