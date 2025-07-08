<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Category;

$category = new Category($db);

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    echo 'Invalid category ID';
    exit;
}

$data = $category->find($id);

if (!$data) {
    echo 'Category not found.';
    exit;
}
?>
<body>
    <h2>Edit Product</h2>

    <?php if ($session->hasFlash('error')): ?>
        <p><?= $session->getFlash('error') ?></p>
    <?php endif; ?>

    <?php if ($session->hasFlash('success')): ?>
        <p><?= $session->getFlash('success') ?></p>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/categories/edit" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" required><br>
        <button type="submit">Update</button>
    </form>
</body>
