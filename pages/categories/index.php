<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Category;

$category = new Category($db);

$search = trim($_GET['search'] ?? '');
$categories = [];

if ($search !== '') {
    $categories = $category->search($search, $search);
} else {
    $categories = $category->all();
}
?>
<body>
<?php if ($session->hasFlash('error')): ?>
    <p><?= $session->getFlash('error') ?></p>
<?php endif; ?>

<?php if ($session->hasFlash('success')): ?>
    <p><?= $session->getFlash('success') ?></p>
<?php endif; ?>

<form method="GET" class="mb-4">
    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        placeholder="Search categories...">
    <button type="submit">Search</button>
    <?php if (!empty($_GET['search'])): ?>
        <a href="<?= BASE_URL ?>/categories">Reset</a>
    <?php endif; ?>
</form>

<a href="<?= BASE_URL ?>/categories/create">Add Product</a>

<?php if (!empty($categories)): ?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
        <tr>
            <td><?= $category['id'] ?></td>
            <td><?= htmlspecialchars($category['name']) ?></td>
            <td>
                <a href="categories/edit?id=<?= $category['id'] ?>">Edit</a> |
                <form action="<?= BASE_URL ?>/categories/delete" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline;">
                    <input type="hidden" name="id" value="<?= $category['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>
    <p>No categories found.</p>
<?php endif; ?>
