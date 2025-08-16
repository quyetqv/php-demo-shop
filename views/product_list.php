<?php include 'includes/header.php'; ?>
<div class="container">
    <p style="color: #888; font-size: 13px;">Query time: <?php echo isset($queryTime) ? $queryTime . ' ms' : ''; ?></p>
    <h2>Product List</h2>
    <form method="get" action="/products" style="margin-bottom: 16px;">
        <input type="text" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="Search by name...">
        <button type="submit" class="btn">Search</button>
    </form>
    <a href="/products/create" class="btn">Add New Product</a>
    <a href="/cart" class="btn" style="float:right;">
        🛒 Giỏ hàng (<span id="cart-count">
            <?php
                if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    // If cart is an array of product_id => quantity
                    $first = reset($_SESSION['cart']);
                    if (is_array($_SESSION['cart']) && is_numeric($first)) {
                        echo array_sum($_SESSION['cart']);
                    } else {
                        // If cart is an array of product_ids only
                        echo count($_SESSION['cart']);
                    }
                } else {
                    echo 0;
                }
            ?>
        </span>)
    </a>
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
                    <form method="post" action="/cart/add" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn">Thêm vào giỏ</button>
                    </form>
                    <button class="btn-delete" data-id="<?php echo $product['id']; ?>">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <div style="margin-top:16px;">
        <?php $page = $page ?? 1; ?>
        <?php if ($page > 1): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => 1])); ?>">First</a>
            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">&laquo; Prev</a>
        <?php endif; ?>
        <?php if ($page > 2): ?>
            ...
        <?php endif; ?>
        <?php if ($page > 1): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>"><?php echo $page - 1; ?></a>
        <?php endif; ?>
        <strong><?php echo $page; ?></strong>
        <?php if ($page < $totalPages): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>"><?php echo $page + 1; ?></a>
        <?php endif; ?>
        <?php if ($page < $totalPages - 1): ?>
            ...
        <?php endif; ?>
        <?php if ($page < $totalPages): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Next &raquo;</a>
            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $totalPages])); ?>">Last</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>