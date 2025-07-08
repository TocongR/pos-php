<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Product;

$product = new Product($db);

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);
$categoryId = intval($_POST['category_id']);


if ($name === '' || $price <= 0 || $stock < 0 || !$categoryId) {
    $session->flash('error', 'Please fill in all the required fields');
    header('Location: ' . BASE_URL . '/products/create');
    exit;
}

$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
    $type = mime_content_type($_FILES['image']['tmp_name']);
    if (in_array($type, $allowedTypes)) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('product_', true) . '.' . $ext;
        $targetPath = __DIR__ . '../../../storage/uploads/products/' . $newFileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = 'uploads/products/' . $newFileName;
        }
    }
}

$success = $product->create($name, $description, $price, $stock, $imagePath, $categoryId);

if ($success) {
    $session->flash('success', 'Product added successfully.');
} else {
    $session->flash('error', 'Something went wrong.');
}

header('Location: ' . BASE_URL . '/products');
exit;