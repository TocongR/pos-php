<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

$productId = $_POST['product_id'] ?? null;
$removeQty = intval($_POST['remove_qty'] ?? 1);
$cart = $session->get('cart', []);

if (!$productId || !isset($cart[$productId])) {
    $session->flash('error', 'Cannot find product.');
    header('Location: ' . BASE_URL . '/sales');
    exit;
}

if ($removeQty >= $cart[$productId]['quantity']) {
    unset($cart[$productId]);
} else {
    $cart[$productId]['quantity'] -= $removeQty;
}

$session->set('cart', $cart);
$session->flash('error', 'Item removed.');
header('Location: ' . BASE_URL . '/sales');
exit;