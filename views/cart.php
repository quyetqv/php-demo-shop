<?php include __DIR__ . '/includes/header.php'; ?>
<div class="container">
    <h2>Your Cart</h2>
    <?php if (empty($products)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
    <form method="post" action="/cart/update">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                    <td><input type="number" name="quantities[<?php echo $product['id']; ?>]" value="<?php echo $product['quantity']; ?>" min="1"></td>
                    <td>$<?php echo $product['subtotal']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Total: $<?php echo $total; ?></strong></p>
        <button type="submit" class="btn">Update Cart</button>
    </form>
    <form method="post" action="/cart/clear" style="margin-top:10px;">
        <button type="submit" class="btn btn-delete">Clear Cart</button>
    </form>
    <form method="post" action="/order/create" style="margin-top:10px;">
        <button type="submit" class="btn">Thanh toán</button>
    </form>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success" style="margin-top:10px; color:green;">Thanh toán thành công!</div>
    <?php endif; ?>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
