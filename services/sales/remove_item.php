<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

$productId = $_POST['product_id'] ?? null;
$cart = $session->get('cart', []);

if (!$productId || !isset($cart[$productId])) {
    $session->flash('error', 'Cannot find product.');
    header('Location: ' . BASE_URL . '/sales');
    exit;
}

unset($cart[$productId]);
$session->set('cart', $cart);
$session->flash('success', 'Item removed.');

header('Location: ' . BASE_URL . '/sales');
exit;