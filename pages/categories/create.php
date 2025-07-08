<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
</head>
<body>
    <h2>Add Category</h2>
    
    <?php if ($session->hasFlash('error')): ?>
        <p><?= $session->getFlash('error') ?></p>
    <?php endif; ?>

    <?php if ($session->hasFlash('success')): ?>
        <p><?= $session->getFlash('success') ?></p>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/categories/create" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Name" required><br>
        <button type="submit">Add</button>
    </form>
</body>
</html>
