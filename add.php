<?php include 'header.php'; ?>
<div class="form-container">
    <h1>Add New Bakery Item</h1>
    <form action="process.php" method="post">
        <label>Item Name:</label>
        <input type="text" name="name" required>
        <label>Description:</label>
        <textarea name="description" rows="4" required></textarea>
        <label>Price ($):</label>
        <input type="number" name="price" step="0.01" required>
        <button type="submit" name="action" value="add">Add Item</button>
    </form>
</div>
<?php include 'footer.php'; ?>
