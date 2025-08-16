<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Add New Product</h2>
    <form action="/products/create" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id">
            <option value="1">Electronics</option>
            <option value="2">Books</option>
        </select>
        
        <button type="submit" class="btn">Save Product</button>
    </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>