<?php
include 'connect.php';
include 'footer.php';
// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS Item (
    name VARCHAR(30) NOT NULL PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL
)";

if (!$conn->query($sql)) {
    die("Error creating table: " . $conn->error);
}

// Check if table is empty
$sql_check = "SELECT COUNT(*) as count FROM Item";
$result = $conn->query($sql_check);

if (!$result) {
    die("Error checking table: " . $conn->error);
}

$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    // Insert bakery-related dummy data
    $sql_insert = "INSERT INTO Item (name, description, price) VALUES
    ('Sourdough Bread', 'Traditional sourdough with a crispy crust', 4.99),
    ('Chocolate Cake', 'Rich and moist chocolate cake with ganache', 15.99),
    ('Croissant', 'Flaky and buttery French pastry', 2.49),
    ('Blueberry Muffin', 'Soft muffin with fresh blueberries', 3.49),
    ('Cinnamon Roll', 'Sweet roll with cinnamon and cream cheese icing', 3.99)";

    if (!$conn->query($sql_insert)) {
        die("Error inserting dummy data: " . $conn->error);
    }
} else {
    echo "Table is not empty, skipping dummy data insertion.<br>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input
    $action = $_POST['action'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = $_POST['price'] ?? '';

    // Check for missing required fields
    if (!$name || !$description || !$price) {
        die("Error: Missing required fields (name, description, price).<br>");
    } elseif (!is_numeric($price)) {
        die("Error: Price must be a valid number.<br>");
    }

    // Handle different actions
    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO Item (name, description, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $description, $price);
        if (!$stmt->execute()) {
            die("Error adding item: " . $stmt->error);
        }
        echo "Item added successfully!<br>";
        $stmt->close();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM Item WHERE name = ?");
        $stmt->bind_param("s", $name);
        if (!$stmt->execute()) {
            die("Error deleting item: " . $stmt->error);
        }
        echo "Item deleted successfully!<br>";
        $stmt->close();
    } elseif ($action === 'edit') {
        $stmt = $conn->prepare("UPDATE Item SET description = ?, price = ? WHERE name = ?");
        $stmt->bind_param("ssd", $description, $price, $name);
        if (!$stmt->execute()) {
            die("Error updating item: " . $stmt->error);
        }
        echo "Item updated successfully!<br>";
        $stmt->close();
    } else {
        die("Error: Invalid action.<br>");
    }
}
$conn->close();
?>
