<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

$cart = $session->get('cart', []);
$total = 0;
?>

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
                    <form class="removeProductForm">
                        <input type="hidden" id="product" name="product_id" value="<?= $id ?>">
                        <input type="number" id="quantity" name="remove_qty" value="1" min="1" max="<?= $item['quantity'] ?>">
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Total: ₱<?= number_format($total, 2) ?></h3>