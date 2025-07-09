<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Product;

header('Content-Type: application/json');

$product = new Product($db);

$productId = $_POST['product_id'] ?? null;
$quantity = intval($_POST['quantity']) ?? 1;

if (!$productId|| $quantity <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product or quantity.']);
    exit;
}

$product = $product->find($productId);

if (!$product) {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found.']);
    exit;
}

$cart = $session->get('cart', []);
$currentQuantityInCart = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
$totalQuantity = $currentQuantityInCart + $quantity;

if ($totalQuantity > $product['stock']) {
    echo json_encode(['error' => "Only {$product['stock']} units available"]);
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
echo json_encode(['success' => 'Product added to cart.']);
exit;