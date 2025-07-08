<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Sale;

$sale = new Sale($db);
$sales = $sale->all();
?>
<h1>All Transactions</h1>

<table>
    <thead>
        <tr>
            <th>Sale ID</th>
            <th>Cashier</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Paid</th>
            <th>Change</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
       <?php foreach ($sales as $sale): ?>
            <tr>
                <td><?= $sale['id'] ?></td>
                <td><?= htmlspecialchars($sale['cashier_name']) ?></td>
                <td><?= number_format($sale['total'], 2) ?></td>
                <td><?= $sale['payment_method'] ?></td>
                <td><?= number_format($sale['amount_paid'], 2) ?></td>
                <td><?= number_format($sale['change'], 2) ?></td>
                <td><?= $sale['created_at'] ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/orders/view?id=<?= $sale['id'] ?>">View</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>