<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Product;

$product = new Product($db);

$id = $_POST['id'] ?? null;

if (!$id || !is_numeric($id)) {
    $session->flash('error', 'Invalid data');
    header('Location: ' . BASE_URL . '/products');
    exit;
}

$existing = $product->find($id);
if (!$existing) {
    $session->flash('error', 'Product not found.');
    header('Location: ' . BASE_URL . '/products');
    exit;
}

$path = __DIR__ . '/../../storage/' . $existing['image'];

if (!empty($existing['image']) && file_exists($path)) {
    unlink($path);
}

$success = $product->delete($id);

if ($success) {
    $session->flash('success', 'Product deleted successfully');
} else {
    $session->flash('error', 'Failed to delete product.');
}

header('Location: ' . BASE_URL . '/products');
exit;