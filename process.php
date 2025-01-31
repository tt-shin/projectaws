<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input
    $action = $_POST['action'] ?? '';
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $description = $conn->real_escape_string($_POST['description'] ?? '');
    $price = $_POST['price'] ?? '';

    // Check if price is a valid number
    if (!is_numeric($price)) {
        die("Error: Price must be a valid number.<br>");
    }

    if ($action === 'add') {
        if (!$name || !$description || !$price) {
            die("Error: Missing required fields (name, description, price).<br>");
        }
        $stmt = $conn->prepare("INSERT INTO Item (name, description, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $description, $price);
        if ($stmt->execute()) {
            echo "Item added successfully!";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } 
    
    elseif ($action === 'delete') {
        if (!$name) {
            die("Error: Name is required to delete an item.<br>");
        }
        $stmt = $conn->prepare("DELETE FROM Item WHERE name = ?");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            echo "Item deleted successfully!";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } 
    
    elseif ($action === 'edit') {
        if (!$name || !$description || !$price) {
            die("Error: Missing fields for editing item.<br>");
        }
        
        // Check if the item exists
        $stmt = $conn->prepare("SELECT * FROM Item WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            die("Error: Item not found.<br>");
        }

        // Proceed with update
        $stmt = $conn->prepare("UPDATE Item SET description = ?, price = ? WHERE name = ?");
        $stmt->bind_param("ssd", $description, $price, $name);
        if ($stmt->execute()) {
            echo "Item updated successfully!";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } 
    
    else {
        echo "Error: Invalid action.<br>";
    }
}

$conn->close();
?>
