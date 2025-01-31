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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bakery Items</h1>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='item-card'>";
                echo "<h2>" . htmlspecialchars($row["name"]) . "</h2>";
                echo "<p>" . htmlspecialchars($row["description"]) . "</p>";
                echo "<p><strong>Price:</strong> $" . htmlspecialchars($row["price"]) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-items'>No items found.</p>";
        }
        ?>
    </div>
    <?php
    // Close the connection
    $conn->close();
    include('footer.php');
    ?>
</body>
</html>
