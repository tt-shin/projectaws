<?php
// Database connection
$servername = "project-db.cc7tazxltrra.us-east-1.rds.amazonaws.com"; // Use the appropriate hostname
$username = "admin"; // Replace with your database username
$password = "awsprojectdb"; // Replace with your database password
$dbname = "projectaws"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all items from the database
$sql = "SELECT * FROM Item"; // Assuming the table is named 'items'
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Items - My Apache Bakery</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="navbar">
        <a href="tcc.php" class="logo">My Apache Bakery</a>
        <div class="menu">
            <div class="menu-item">
                <a href="view.php">View Items</a>
            </div>
            <div class="menu-item">
                <a href="add.php">Add Items</a>
            </div>
            <div class="menu-item">
                <a href="edit.php">Edit Items</a>
            </div>
            <div class="menu-item">
                <a href="delete.php">Delete Items</a>
            </div>
        </div>
    </div>
    
    <div class="bb"><a href="tcc.php">Homepage</a></div>

    <div class="items-container">
        <h1>Bakery Items</h1>
        <div class="items-list">
            <?php
            if ($result->num_rows > 0) {
                // Output each item
                while($row = $result->fetch_assoc()) {
                    echo "<div class='item'>
                            <h2>" . $row["name"] . "</h2>
                            <p>" . $row["description"] . "</p>
                            <p><strong>Price:</strong> $" . $row["price"] . "</p>
                          </div>";
                }
            } else {
                echo "<p>No items found.</p>";
            }

            // Close the connection
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
