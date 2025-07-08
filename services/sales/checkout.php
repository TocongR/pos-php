<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Sale;

$sale = new Sale($db);

$cart = $session->get('cart', []);
if (empty($cart)) {
    $session->flash('error', 'Cart is empty.');
    header('Location: ' . BASE_URL . '/sales');
    exit;
}

$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

$amountPaid = $_POST['amount'] ?? 0;
$paymentMethod = $_POST['payment_method'] ?? 'cash';
$change = $amountPaid - $total;

if ($amountPaid < $total) {
    $session->flash('error', 'Amount paid is less than total');
    header('Location: ' . BASE_URL . '/sales');
    exit;
}

$data = [
    'user_id' => $session->get('user_id'),
    'total' => $total,
    'payment_method' => $paymentMethod,
    'amount_paid' => $amountPaid,
    'change' => $change
];

$saleId = $sale->create($data);
$sale->addItems($saleId, $cart);

$session->remove('cart');
$session->flash('success', 'Transaction complete. Change: ₱' . number_format($change, 2));
header('Location: ' . BASE_URL .'/sales');
exit;