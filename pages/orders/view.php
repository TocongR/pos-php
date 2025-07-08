<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Sale;

$sale = new Sale($db);

$id = $_GET['id'] ?? null;
$data = $sale->find($id);
$items = $sale->getItems($id);
?>
<h2>Sale #<?= $data['id'] ?> Details</h2>
<p><strong>Cashier:</strong> <?= htmlspecialchars($data['cashier_name']) ?></p>
<p><strong>Payment:</strong> <?= $data['payment_method'] ?></p>
<p><strong>Paid:</strong> ₱<?= number_format($data['amount_paid'], 2) ?></p>
<p><strong>Change:</strong> ₱<?= number_format($data['change'], 2) ?></p>
<p><strong>Date:</strong> <?= $data['created_at'] ?></p>

<h3>Items</h3>
<table>
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Subtotal</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>₱<?= number_format($item['price'], 2) ?></td>
            <td>₱<?= number_format($item['subtotal'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
</table>