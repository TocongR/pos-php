<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Product;

$product = new Product($db);

$productId = $_POST['product_id'] ?? null;
$quantity = intval($_POST['quantity']) ?? 1;

if (!$productId|| $quantity <= 0) {
    $session->set('error', 'Invalid product or quantity.');
    header('Location: ' . BASE_URL . '/sales');
    exit;
}

$product = $product->find($productId);

if (!$product) {
    $session->set('error', 'Product not found.');
    header('Location: ' . BASE_URL . '/sales');
    exit;
}

$cart = $session->get('cart', []);
$currentQuantityInCart = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
$totalQuantity = $currentQuantityInCart + $quantity;

if ($totalQuantity > $product['stock']) {
    $session->flash('error', 'Not enough stock available. Only' . ' ' . $product['stock'] . ' ' . 'units in stock');
    header('Location: ' . BASE_URL . '/sales');
    exit;
}

if (isset($cart[$productId])) {
    $cart[$productId]['quantity'] += $quantity;
} else {
    $cart[$productId] = [
        'id' => $product['id'],
        'image' => $product['image'],
        'name' => $product['name'],
        'price' => $product['price'],
        'stock' => $product['stock'],
        'category' => $product['category_name'],
        'quantity' => $quantity
    ];
}

$session->set('cart', $cart);

$session->flash('success', 'Product added to cart.');
header('Location: ' . BASE_URL . '/sales');
exit;