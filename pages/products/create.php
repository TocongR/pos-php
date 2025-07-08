<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Category;

$category = new Category($db);
$categories = $category->all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
</head>
<body>
    <h2>Add Product</h2>

    <?php if ($session->hasFlash('error')): ?>
        <p><?= $session->getFlash('error') ?></p>
    <?php endif; ?>

    <?php if ($session->hasFlash('success')): ?>
        <p><?= $session->getFlash('success') ?></p>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/products/create" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Name" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <input type="number" name="price" placeholder="Price" step="0.01" required><br>
        <input type="number" name="stock" placeholder="Stock" required><br>
        <input type="file" name="image" accept="image/*"><br>
        <select name="category_id">
            <option value="" disabled selected>-- Select Category --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Add</button>
    </form>
</body>
</html>
