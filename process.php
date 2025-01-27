<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'] ?? '';
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $description = $conn->real_escape_string($_POST['description'] ?? '');
    $price = $conn->real_escape_string($_POST['price'] ?? '');

    if ($action === 'add' && $name && $description && $price) {
        $sql = "INSERT INTO Item (name, description, price) VALUES ('$name', '$description', '$price')";
    } elseif ($action === 'delete' && $name) {
        $sql = "DELETE FROM Item WHERE name = '$name'";
    } elseif ($action === 'edit' && $name && $description && $price) {
        $sql = "UPDATE Item SET description='$description', price='$price' WHERE name='$name'";
    }

    if (isset($sql) && $conn->query($sql) === TRUE) {
        echo "Action '$action' completed successfully!";
    } else {
        echo "Error: " . ($sql ?? 'Invalid action') . "<br>" . $conn->error;
    }
}

$conn->close();
?>
