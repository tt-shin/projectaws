<!DOCTYPE html>
<html>
    <head>

</head>
<body>

<?php
    $Name = $_POST['name'];
    $Description = $_POST['description'];
    $Price = $_POST['price'];

    // Database connection
    $servername = "project-db.cc7tazxltrra.us-east-1.rds.amazonaws.com";
    $username = "admin"; // Update with your database username
    $password = "awsprojectdb"; // Update with your database password
    $dbname = "projectaws"; // Update with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Get form data
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $price = $conn->real_escape_string($_POST['price']);

        // Insert the new item into the database
        $sql = "INSERT INTO Item (name, description, price) VALUES ('$name', '$description', '$price')";

        if ($conn->query($sql) === TRUE) {
            echo "New item added successfully!";
            echo "<a href='add.php'>Add another item</a> | <a href='view.php'>View Items</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
?>
</body>
</html>