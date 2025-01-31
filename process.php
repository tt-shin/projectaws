<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get input and sanitize
    $action = $_POST['action'] ?? '';
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $description = isset($_POST['description']) ? $conn->real_escape_string($_POST['description']) : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;

    if ($action === 'add') {
        // Validate required fields
        if (!$name || !$description || !$price || !is_numeric($price)) {
            die("Error: Missing required fields (name, description, price) or invalid price.<br>");
        }

        // Insert into the database
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
        // Validate name for deletion
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
        // Validate name before updating
        if (!$name) {
            die("Error: Name is required to edit an item.<br>");
        }

        // Check if item exists
        $stmt = $conn->prepare("SELECT * FROM Item WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            die("Error: Item not found.<br>");
        }
        $stmt->close();

        // Prepare dynamic update query
        $updateFields = [];
        $updateParams = [];
        $paramTypes = "";

        if (!empty($description)) {
            $updateFields[] = "description = ?";
            $updateParams[] = $description;
            $paramTypes .= "s";
        }

        if (!empty($price) && is_numeric($price)) {
            $updateFields[] = "price = ?";
            $updateParams[] = $price;
            $paramTypes .= "d";
        }

        if (empty($updateFields)) {
            die("Error: No fields to update.<br>");
        }

        $query = "UPDATE Item SET " . implode(", ", $updateFields) . " WHERE name = ?";
        $updateParams[] = $name;
        $paramTypes .= "s";

        $stmt = $conn->prepare($query);
        $stmt->bind_param($paramTypes, ...$updateParams);
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
