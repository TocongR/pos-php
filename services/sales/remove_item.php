<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

$productId = $_POST['product_id'] ?? null;
$removeQty = intval($_POST['remove_qty'] ?? 1);
$cart = $session->get('cart', []);

if (!$productId || !isset($cart[$productId])) {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found.']);
    exit;
}

if ($removeQty >= $cart[$productId]['quantity']) {
    unset($cart[$productId]);
} else {
    $cart[$productId]['quantity'] -= $removeQty;
}

$session->set('cart', $cart);
echo json_encode(['success' => 'Item removed']);
exit;