<?php
include 'connect.php';

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS Item (
    name VARCHAR(30) NOT NULL,
    description VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Item created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// SQL to insert bakery-related dummy data
$sql_insert = "INSERT INTO Item (name, description, price) VALUES
('Sourdough Bread', 'Traditional sourdough with a crispy crust', 4.99),
('Chocolate Cake', 'Rich and moist chocolate cake with ganache', 15.99),
('Croissant', 'Flaky and buttery French pastry', 2.49),
('Blueberry Muffin', 'Soft muffin with fresh blueberries', 3.49),
('Cinnamon Roll', 'Sweet roll with cinnamon and cream cheese icing', 3.99)";

if ($conn->query($sql_insert) === TRUE) {
    echo "Bakery dummy data inserted successfully\n";
} else {
    echo "Error inserting data: " . $conn->error . "\n";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input
    $action = $_POST['action'] ?? '';
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $description = $conn->real_escape_string($_POST['description'] ?? '');
    $price = $_POST['price'] ?? '';

    // Check for missing required fields
    if (!$name || !$description || !$price) {
        echo "Error: Missing required fields (name, description, price).<br>";
    } elseif (!is_numeric($price)) {
        echo "Error: Price must be a valid number.<br>";
    } else {
        // Prepare SQL queries based on action
        if ($action === 'add') {
            $stmt = $conn->prepare("INSERT INTO Item (name, description, price) VALUES (?, ?, ?)");
            $stmt->bind_param("ssd", $name, $description, $price);
            if ($stmt->execute()) {
                echo "Item added successfully!";
            } else {
                echo "Error: " . $stmt->error . "<br>";
                error_log("Error adding item: " . $stmt->error); // Log to file
            }
            $stmt->close();
        } elseif ($action === 'delete') {
            if (!$name) {
                echo "Error: Name is required to delete an item.<br>";
            } else {
                $stmt = $conn->prepare("DELETE FROM Item WHERE name = ?");
                $stmt->bind_param("s", $name);
                if ($stmt->execute()) {
                    echo "Item deleted successfully!";
                } else {
                    echo "Error: " . $stmt->error . "<br>";
                    error_log("Error deleting item: " . $stmt->error); // Log to file
                }
                $stmt->close();
            }
        } elseif ($action === 'edit') {
            if (!$name || !$description || !$price) {
                echo "Error: Missing fields for editing item.<br>";
            } else {
                $stmt = $conn->prepare("UPDATE Item SET description = ?, price = ? WHERE name = ?");
                $stmt->bind_param("ssd", $description, $price, $name);
                if ($stmt->execute()) {
                    echo "Item updated successfully!";
                } else {
                    echo "Error: " . $stmt->error . "<br>";
                    error_log("Error updating item: " . $stmt->error); // Log to file
                }
                $stmt->close();
            }
        } else {
            echo "Error: Invalid action.<br>";
        }
    }
}

$conn->close();
?>
