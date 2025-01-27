<?php include 'header.php'; ?>
<div class="form-container">
    <h1>Delete Bakery Item</h1>
    <form action="process.php" method="post">
        <label for="name">Select Item to Delete:</label>
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
        <button type="submit" name="action" value="delete">Delete Item</button>
    </form>
</div>
<?php include 'footer.php'; ?>
