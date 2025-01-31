<?php
// Include the database connection
include('connect.php');
include('header.php');
// Fetch all items from the database
$sql = "SELECT * FROM Item";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Items</title>
</head>
<body>
    <h1>Bakery Items</h1>
    <?php
    if ($result->num_rows > 0) {
        // Output each item
        while($row = $result->fetch_assoc()) {
            echo "<h2>" . $row["name"] . "</h2>";
            echo "<p>" . $row["description"] . "</p>";
            echo "<p><strong>Price:</strong> $" . $row["price"] . "</p>";
        }
    } else {
        echo "<p>No items found.</p>";
    }

    // Close the connection
    $conn->close();
    include('footer.php');
?>
</body>
</html>
