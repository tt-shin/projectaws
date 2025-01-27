<?php include 'header.php'; ?>
<div class="form-container">
    <h1>Edit Bakery Item</h1>
    <form action="process.php" method="post">
        <label for="name">Select Item to Edit:</label>
        <select name="name" id="name" required>
            <option value="">--Select an item--</option>
            <?php
            include 'connect.php';
            $result = $conn->query("SELECT name FROM Item");
            while ($row = $result->fetch_assoc()) {
                echo "<option value=\"" . htmlspecialchars($row['name']) . "\">" . htmlspecialchars($row['name']) . "</option>";
            }
            $conn->close();
            ?>
        </select>
        <label for="description">New Description:</label>
        <textarea name="description" id="description" rows="4" required></textarea>
        <label for="price">New Price ($):</label>
        <input type="number" name="price" id="price" step="0.01" required>
        <button type="submit" name="action" value="edit">Update Item</button>
    </form>
</div>
<?php include 'footer.php'; ?>
