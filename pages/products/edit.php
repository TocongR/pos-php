<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Product;
use Classes\Category;
$product = new Product($db);
$category = new Category($db);

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    echo 'Invalid product ID';
    exit;
}

$data = $product->find($id);

if (!$data) {
    echo 'Product not found.';
    exit;
}

$categories = $category->all();
?>
<body>
    <h2>Edit Product</h2>

    <?php if ($session->hasFlash('error')): ?>
        <p><?= $session->getFlash('error') ?></p>
    <?php endif; ?>

    <?php if ($session->hasFlash('success')): ?>
        <p><?= $session->getFlash('success') ?></p>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/products/edit" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" required><br>
        <textarea name="description"><?= htmlspecialchars($data['description']) ?></textarea><br>
        <input type="number" name="price" value="<?= $data['price'] ?>" step="0.01" required><br>
        <input type="number" name="stock" value="<?= $data['stock'] ?>" required><br>

        <?php if ($data['image']): ?>
            <img src="/inv_sys_php_oop/storage/<?= htmlspecialchars($data['image']) ?>" width="100"><br>
        <?php endif; ?>

        <input type="file" name="image" accept="image/*"><br>

        <select name="category_id">
            <option value="" disabled selected>-- Select Category --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($data['category_id'] === $cat['id'] ? 'selected' : '' ) ?> >
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit">Update</button>
    </form>
</body>
