<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Product;

$product = new Product($db);

$products = $product->all();

$cart = $session->get('cart', []);
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>POS - Sales</title>
</head>
<body>

    <h1>Point of Sale</h1>

    <h2>Cashier: <?= htmlspecialchars($session->get('user_name', 'John Doe')) ?></h2>
    <h3>Date: <?php echo date('Y-m-d'); ?></h3>
    
    <?php if ($session->hasFlash('error')): ?>
        <p><?= $session->getFlash('error') ?></p>
    <?php endif; ?>

    <?php if ($session->hasFlash('success')): ?>
        <p><?= $session->getFlash('success') ?></p>
    <?php endif; ?>

    <hr>

    <h3>Add Product</h3>
    <form action="<?= BASE_URL ?>/sales/add-item" method="POST">
        <label for="product">Product:</label>
        <select id="product" name="product_id">
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['id'] ?>">
                    <?= htmlspecialchars($product['name']) ?> - ₱<?= number_format($product['price'], 2) ?>
                </option>
            <?php endforeach; ?>
            
        </select><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1"><br><br>

        <button type="submit">Add to Cart</button>
    </form>

    <hr>

    <h3>Cart</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Image</th>
                <th>Category</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $id => $item): ?>
                <?php $subtotal = $item['quantity'] * $item['price']; ?>
                <?php $total += $subtotal; ?>
                <tr>
                    <td>
                        <?php if ($item['image']): ?>
                            <img src="/inv_sys_php_oop/storage/<?= htmlspecialchars($item['image']) ?>" width="100" height="100"><br>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($item['category']) ?></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['price'], 2) ?></td>
                    <td><?= number_format($subtotal, 2) ?></td>
                    <td>
                        <form method="POST" action="<?= BASE_URL ?>/sales/remove-item">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <input type="number" name="remove_qty" value="1" min="1" max="<?= $item['quantity'] ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: ₱<?= number_format($total, 2) ?></h3>

    <form action="<?= BASE_URL ?>/sales/checkout" method="POST">
        <label for="payment">Payment Type:</label>
        <select name="payment_method" id="payment">
            <option value="cash">Cash</option>
            <option value="gcash">GCash</option>
        </select><br><br>

        <label for="amount">Amount Paid:</label>
        <input type="number" name="amount" id="amount" step="0.01"><br><br>

        <button type="submit">Checkout</button>
    </form>

</body>
</html>
