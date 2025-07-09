<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\User;

$user = new User($db);

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    echo 'Invalid category ID';
    exit;
}

$data = $user->find($id);

if (!$data) {
    echo 'User not found.';
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

    <form method="POST" action="<?= BASE_URL ?>/users/edit" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <input type="text" name="username" value="<?= htmlspecialchars($data['username']) ?>" required><br>
        <input type="password" name="current_password" placeholder="Current Password"><br>
        <input type="password" name="password" placeholder="New Password"><br>      
        <select name="role">
            <option value="" disabled selected>-- Select Role --</option>
            <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="manager" <?= $data['role'] === 'manager' ? 'selected' : '' ?>>Manager</option>
            <option value="cashier" <?= $data['role'] === 'cashier' ? 'selected' : '' ?>>Cashier</option>
        </select><br>
        <button type="submit">Update</button>
    </form>
</body>
