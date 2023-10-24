<?php
include '../db_connection.php';

// Your HTML and PHP code follows here.
// You can use the $con variable to perform database operations.
?>

<!DOCTYPE html>
<html>

<head>
    <title>Branches</title>
    <link rel="stylesheet" type="text/css" href="../components/styles/branch.css">

</head>

<body>
    <h1>List of Branches</h1>
    <!-- Display a table of branches with buttons for add, edit, delete -->

    <!-- Add a button to open the form for adding a new branch -->
    <button onclick="openAddBranchForm()">New Branch</button>
    <table>
        <tr>
            <th>Name of Branch</th>
            <th>No of Total Sold Cars</th>
            <th>Actions</th>
        </tr>
        <!-- Display data from the 'branches' table -->
        <?php
        $sql = "SELECT * FROM branch";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $branches = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            echo 'Error fetching branches data: ' . mysqli_error($con);
            $branches = [];
        }

        foreach ($branches as $key => $branch) {
            echo "<tr>";
            echo "<td id='name_$key'>{$branch['name']}</td>";
            echo "<td>{$branch['total_car_sold']}</td>";
            echo "<td class='action-buttons'>
                <button onclick='editBranch($key)'>Edit</button>
                <button onclick='deleteBranch($key)'>Delete</button>
                <button onclick='viewProducts($key)'>View Products</button>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Edit Branch Form (hidden by default) -->
    <div id="editForm" style="display: none;">
        <input type="text" id="editName" placeholder="New Name">
        <button onclick="saveEdit()">Save</button>
        <button onclick="cancelEdit()">Cancel</button>
    </div>

    <!-- Form for adding a new branch (hidden by default) -->
    <div id="addBranchForm" style="display: none;">
        <input type="text" id="branchNameInput" placeholder="Branch Name">
        <input type="text" id="totalSoldCarsInput" placeholder="Total Sold Cars">
        <button onclick="addBranch()">Add Branch</button>
    </div>

    <!-- Modal for viewing products -->
    <div id="productsModal" class="modal">
        <div class="modal-content" style="padding: 100px;">
            <span class="close-button" onclick="closeProductsModal()">&times;</span>
            <h2 style="margin: 5px 0; text-align: center;">Products at <span id="branchName"></span></h2>
            <div class="product-list" style="max-height: 200px; overflow-y: scroll;">
                <!-- Table for car types -->
                <table id="carTypesTable">
                    <tr>
                        <th>Code</th>
                        <th>Description</th>
                        <th>No of Sold Cars</th>
                        <th>Actions</th>
                    </tr>
                    <!-- Sample car type data (replace with actual data from your database) -->
                    <?php
                    foreach ($carTypes as $carType) {
                        echo "<tr>";
                        echo "<td>{$carType['code']}</td>";
                        echo "<td>{$carType['description']}</td>";
                        echo "<td>{$carType['sold_cars']}</td>";
                        echo "<td>
            <div class='action-cartype'>
                <button onclick='viewCars(\"{$carType['code']}\")'>View Cars</button>
                <button onclick='viewCustomers(\"{$carType['code']}\")'>View Customers</button>
                <button onclick='deleteCarType(\"{$carType['code']}\")'>Delete</button>
            </div>
            </td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <!-- Button to add a new car type (inside the "Cars of" modal) -->
                <button onclick="addCarType()">Add Car Type</button>
            </div>
        </div>
    </div>

    <!-- Form for adding a new car type (hidden by default, inside the "Cars of" modal) -->
    <div id="addCarTypeForm" class="modal" style="display: none;">
        <div class="modal-content" style="padding: 20px;">
            <span class="close-button" onclick="closeAddCarTypeForm()">&times;</span>
            <h2 style="margin: 5px 0; text-align: center;">Add New Car Type</h2>
            <form id="carTypeForm" onsubmit="saveCarType(event);"> <!-- Set onsubmit to trigger saveCarType -->
                <label for="newCarTypeCode">Code:</label>
                <input type="text" id="newCarTypeCode" required>
                <br>

                <input type="text" id="newCarTypeDescription" required>
                <br>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>

    <!-- Display the input information for the added car type (inside the "Cars of" modal) -->
    <div id="displayCarTypeInfo" style="display: none;">
        <h2>Car Type Information:</h2>
        <p><strong>Code:</strong> <span id="displayCarTypeCode"></span></p>
        <p><strong>Description:</strong> <span id="displayCarTypeDescription"></span></p>
    </div>

    <!-- Modal for viewing cars per car type -->
    <div id="carsModal" class="modal">
        <div class="modal-content" style="padding: 20px;">
            <span class="close-button" onclick="closeCarsModal()">&times;</span>
            <h2 style="margin: 5px 0; text-align: center;">Cars for Car Type <span id="carTypeCodeCars"></span></h2>
            <table id="carTable">
                <tr>
                    <th>Car Model</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th>Car Type</th>
                </tr>
                <!-- PHP code to populate car data based on car type -->
                <?php foreach ($cars as $car) : ?>
                    <tr>
                        <td><?php echo $car['car_mode']; ?></td>
                        <td><?php echo $car['color']; ?></td>
                        <td><?php echo $car['price']; ?></td>
                        <td><?php echo $car['car_type_id']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>


    <!-- Modal for viewing customers per car type of a branch -->
    <div id="customersModal" class="modal">
        <div class="modal-content" style="padding: 20px;">
            <span class="close-button" onclick="closeCustomersModal()">&times;</span>
            <h2 style="margin: 5px 0; text-align: center;">Customers for Car Type <span id="carTypeCodeCustomers"></span></h2>
            <table id="customerTable">
                <tr>
                    <th>Name of Customer</th>
                    <th>Contact Info</th>
                    <th>Address</th>
                    <th>Date and Time Purchased</th>
                    <th>Car Type</th>
                </tr>
                <!-- Sample customer data (replace with actual data from your database) -->
                <?php foreach ($customers as $customer) : ?>
                    <tr>
                        <td><?php echo $customer['name']; ?></td>
                        <td><?php echo $customer['contact_info']; ?></td>
                        <td><?php echo $customer['address']; ?></td>
                        <td><?php echo $customer['purchase_date']; ?></td>
                        <td><?php echo $customer['car_type_id']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <script>
        var currentlyEditing = -1;

        // Function to open the "New Branch" form
        function openAddBranchForm() {
            document.getElementById('addBranchForm').style.display = 'block';
        }

        // Function to add a new branch
        function addBranch() {
            var branchName = document.getElementById('branchNameInput').value;
            var totalSoldCars = document.getElementById('totalSoldCarsInput').value;

            // Perform an AJAX request to add the branch to the database (server-side operation).
            // After adding the branch, you can update the table to reflect the new branch.
            // For now, we'll simply add the new branch to the table on the front-end.

            var table = document.querySelector('table');
            var newRow = table.insertRow(table.rows.length);

            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = branchName;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = totalSoldCars;

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = `
            <button onclick="editBranch(${table.rows.length - 1})">Edit</button>
            <button onclick="deleteBranch(${table.rows.length - 1})">Delete</button>
            <button onclick="viewProducts(${table.rows.length - 1})">View Products</button>
        `;

            // Clear the input fields and hide the form
            document.getElementById('branchNameInput').value = '';
            document.getElementById('totalSoldCarsInput').value = '';
            document.getElementById('addBranchForm').style.display = 'none';
        }

        function editBranch(index) {
            currentlyEditing = index;
            var branchName = document.getElementById('name_' + index).innerText;
            document.getElementById('editName').value = branchName;
            document.getElementById('editForm').style.display = 'block';
        }

        function deleteBranch(index) {
            if (confirm('Are you sure you want to delete this branch?')) {
                var row = document.getElementById('name_' + branchID).parentNode;
                row.remove();
            }
        }

        function saveEdit() {
            if (currentlyEditing !== -1) {
                var editedName = document.getElementById('editName').value;
                document.getElementById('name_' + currentlyEditing).innerText = editedName;
                document.getElementById('editForm').style.display = 'none';
                currentlyEditing = -1;
            }
        }

        function cancelEdit() {
            document.getElementById('editForm').style.display = 'none';
            currentlyEditing = -1;
        }

        function viewProducts(index) {
            var branchName = document.getElementById('name_' + index).innerText;
            document.getElementById('branchName').innerText = branchName;
            document.getElementById('productsModal').style.display = 'block';

            // You have already fetched and stored car type data from the database in PHP as $carTypes
            // Loop through the actual car type data retrieved from the database
            var carTypesTable = document.getElementById('carTypesTable');
            carTypesTable.innerHTML = '<tr><th>Code</th><th>Description</th><th>No of Sold Cars</th><th>Actions</th></tr>';

            <?php foreach ($carTypes as $carType) { ?>
                var row = carTypesTable.insertRow(-1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);

                cell1.innerHTML = '<?php echo $carType['code']; ?>';
                cell2.innerHTML = '<?php echo $carType['description']; ?>';
                cell3.innerHTML = '<?php echo $carType['sold_cars']; ?>';

                var deleteCarTypeButton = document.createElement('button');
                deleteCarTypeButton.innerHTML = 'Delete';
                deleteCarTypeButton.onclick = function() {
                    if (confirm('Are you sure you want to delete this car type?')) {
                        // Implement your delete car type logic here.
                        // You may want to send an AJAX request to delete the car type.
                        // For now, we'll remove the row from the table without server interaction.
                        row.remove(); // Remove the car type's row from the table
                    }
                };
                cell4.appendChild(deleteCarTypeButton);

                var viewCarsButton = document.createElement('button');
                viewCarsButton.innerHTML = 'View Cars';
                viewCarsButton.onclick = function() {
                    viewCars('<?php echo $carType['code']; ?>');
                };
                cell4.appendChild(viewCarsButton);

                var viewCustomersButton = document.createElement('button');
                viewCustomersButton.innerHTML = 'View Customers';
                viewCustomersButton.onclick = function() {
                    viewCustomers('<?php echo $carType['code']; ?>');
                };
                cell4.appendChild(viewCustomersButton);
            <?php } ?>
        }

        function addCarType() {
            document.getElementById('addCarTypeForm').style.display = 'block';
        }

        function closeAddCarTypeForm() {
            document.getElementById('addCarTypeForm').style.display = 'none';
        }

        function closeProductsModal() {
            document.getElementById('productsModal').style.display = 'none';
        }

        function viewCars(carTypeCode) {
            console.log('Viewing cars for car type:', carTypeCode);
            var carTypeCodeElement = document.getElementById('carTypeCodeCars');
            carTypeCodeElement.innerText = carTypeCode;

            var carTable = document.getElementById('carTable');
            carTable.innerHTML = '<tr><th>Car Model</th><th>Color</th><th>Price</th><th>Car Type</th></tr>';

            // Loop through the actual car data retrieved from the database
            <?php foreach ($cars as $car) : ?>
                if ('<?= $car['car_type_id'] ?>' === carTypeCode) {
                    var row = carTable.insertRow(-1);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);

                    cell1.innerHTML = '<?= $car['car_mode'] ?>';
                    cell2.innerHTML = '<?= $car['color'] ?>';
                    cell3.innerHTML = '<?= $car['price'] ?>';
                    cell4.innerHTML = '<?= $car['car_type_id'] ?>';
                }

            <?php endforeach; ?>

            document.getElementById('carsModal').style.display = 'block';
        }

        function viewCustomers(carModel) {
            var carTypeCodeCustomersElement = document.getElementById('carTypeCodeCustomers');
            carTypeCodeCustomersElement.innerText = carModel;
            document.getElementById('customersModal').style.display = 'block';

            sampleCustomers.forEach(function(customer) {
                var row = customerTable.insertRow(-1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);

                cell1.innerHTML = customer.name;
                cell2.innerHTML = customer.contact;
                cell3.innerHTML = customer.address;
                cell4.innerHTML = customer.purchaseDate;
                cell5.innerHTML = customer.carTypeId;
            });
        }

        function closeCustomersModal() {
            document.getElementById('customersModal').style.display = 'none';
        }

        function closeCarsModal() {
            document.getElementById('carsModal').style.display = 'none';
        }

        function saveCarType(event) {
            event.preventDefault();
            var newCarTypeCode = document.getElementById('newCarTypeCode').value;
            var newCarTypeDescription = document.getElementById('newCarTypeDescription').value;

            var carTypesTable = document.getElementById('carTypesTable');

            var row = carTypesTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            cell1.innerHTML = newCarTypeCode;
            cell2.innerHTML = newCarTypeDescription;
            cell3.innerHTML = ''; // Leave this cell empty

            var buttonContainer = document.createElement('div');

            // "Delete" button
            var deleteCarTypeButton = document.createElement('button');
            deleteCarTypeButton.innerHTML = 'Delete';
            deleteCarTypeButton.className = 'action-cartype'; // Add the 'action-buttons' class
            deleteCarTypeButton.onclick = function() {
                if (confirm('Are you sure you want to delete this car type?')) {
                    // Implement your delete car type logic here.
                    // You may want to send an AJAX request to delete the car type.
                    // For now, we'll remove the row from the table without server interaction.
                    row.remove(); // Remove the car type's row from the table
                }
            };
            buttonContainer.appendChild(deleteCarTypeButton);

            // "View Cars" button
            var viewCarsButton = document.createElement('button');
            viewCarsButton.innerHTML = 'View Cars';
            viewCarsButton.className = 'action-cartype view-cars'; // Add the 'action-cartype' class with 'view-cars' class
            viewCarsButton.onclick = function() {
                // Pass the car type code associated with the currently iterated car type
                viewCars('<?php echo $carType['code']; ?>');
            };
            buttonContainer.appendChild(viewCarsButton);

            // "View Customers" button
            var viewCustomersButton = document.createElement('button');
            viewCustomersButton.innerHTML = 'View Customers';
            viewCustomersButton.className = 'action-cartype view-customers'; // Add the 'action-cartype' class with 'view-customers' class
            viewCustomersButton.onclick = function() {
                viewCustomers(newCarTypeCode);
            };
            buttonContainer.appendChild(viewCustomersButton);

            cell4.appendChild(buttonContainer);

            document.getElementById('newCarTypeCode').value = '';
            document.getElementById('newCarTypeDescription').value = '';
            document.getElementById('addCarTypeForm').style.display = 'none';
        }
    </script>

</body>

</html>