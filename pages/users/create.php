<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
</head>
<body>
    <h2>Add User</h2>

    <?php if ($session->hasFlash('error')): ?>
        <p><?= $session->getFlash('error') ?></p>
    <?php endif; ?>

    <?php if ($session->hasFlash('success')): ?>
        <p><?= $session->getFlash('success') ?></p>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/users/create" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <select name="role">
            <option value="" disabled selected>-- Select Role --</option>
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
            <option value="manager">Cashier</option>
        </select><br>
        <button type="submit">Add</button>
    </form>
</body>
</html>
