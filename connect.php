<?php
$servername = "project-db.cc7tazxltrra.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "awsprojectdb";
$dbname = "projectaws";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// Close connection
$conn->close();
?>