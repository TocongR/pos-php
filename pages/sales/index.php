<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Product;

$product = new Product($db);

$products = $product->all();
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
    <form class="addProductForm">
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

    <div id="cartContainer">
        <?php include __DIR__ . '/../../services/sales/cart-partial.php'; ?>
    </div>
    
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
<script>
document.addEventListener('submit', async (e) => {
    if (e.target.matches('.addProductForm')) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await fetch('/inv_sys_php_oop/public/sales/add-item', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                updateCartUI();
            } else {
                alert(result.error);
            }
        } catch (error) {
            console.error('AJAX error:', error);
            alert('Something went wrong.');
        }
    }
    
});

document.addEventListener('submit', async (e) => {
    if (e.target.matches('.removeProductForm')) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await fetch('/inv_sys_php_oop/public/sales/remove-item', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                updateCartUI();
            } else {
                alert(result.error);
            }
        } catch (error) {
            console.error('AJAX error:', error);
            alert('Something went wrong.');
        }
    }
});

async function updateCartUI() {
    try {
        const response = await fetch('/inv_sys_php_oop/public/sales/cart-partial');
        const html = await response.text();
        document.getElementById('cartContainer').innerHTML = html;
    } catch (error) {
        console.error('Failed to update Cart UI: ', error);
        alert('Failed to update cart. Please refresh manually');
    }
}

</script>
</html>
