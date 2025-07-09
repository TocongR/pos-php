<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\User;

$user = new User($db);

$users = $user->all();
?>
<body>
<?php if ($session->hasFlash('error')): ?>
    <p><?= $session->getFlash('error') ?></p>
<?php endif; ?>

<?php if ($session->hasFlash('success')): ?>
    <p><?= $session->getFlash('success') ?></p>
<?php endif; ?>

<a href="<?= BASE_URL ?>/users/create">Add User</a>

<?php if (!empty($users)): ?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= $user['role'] ?></td>
            <td>
                <a href="<?= BASE_URL ?>/users/edit?id=<?= $user['id'] ?>">Edit</a> |
                <form action="<?= BASE_URL ?>/users/delete" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline;">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>
