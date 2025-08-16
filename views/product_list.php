<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Product List</h2>
    <a href="/products/create" class="btn">Add New Product</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['id']); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                <td>
                    <button class="btn-delete" data-id="<?php echo $product['id']; ?>">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>