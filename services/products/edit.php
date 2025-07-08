<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Product;

$product = new Product($db);

$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);
$categoryId = intval($_POST['category_id'] ?? '');


if (!$id || !is_numeric($id) || $name === '' || $price <= 0 || $stock < 0 || !$categoryId) {
    $session->flash('error', 'Invalid data');
    header('Location:' . BASE_URL . '/products/edit?id=' . $id);
    exit;
}

$imagePath = null;
$existing = $product->find($id);

if (!$existing) {
    $session->flash('error', 'Product not found.');
    header("Location: " . BASE_URL . "/products");
    exit;
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $type = mime_content_type($_FILES['image']['tmp_name']);
    if (in_array($type, $allowedTypes)) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('product_', true) . '.' . $ext;
        $targetPath = __DIR__ . '/../../storage/uploads/products/' . $newFileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = 'uploads/products/' . $newFileName;

            if (!empty($existing['image'])) {
                $oldImagePath = __DIR__ . '/../../storage/' . $existing['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }
    }
}

$success = $product->update($id, $name, $description, $price, $stock, $imagePath, $categoryId);

if ($success) {
    $session->flash('success', 'Product updated successfully.');    
} else {
    $session->flash('error', 'Product update failed.');
}

header('Location: ' . BASE_URL . '/products');
exit;