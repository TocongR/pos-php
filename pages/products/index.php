<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Product;

$product = new Product($db);

$search = trim($_GET['search'] ?? '');
$products = [];

if ($search !== '') {
    $products = $product->search($search, $search);
} else {
    $products = $product->all();
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
        placeholder="Search products...">
    <button type="submit">Search</button>
    <?php if (!empty($_GET['search'])): ?>
        <a href="<?= BASE_URL ?>/products">Reset</a>
    <?php endif; ?>
</form>

<a href="<?= BASE_URL ?>/products/create">Add Product</a>

<?php if (!empty($products)): ?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td>
                <?php if ($product['image']): ?>
                    <img src="/inv_sys_php_oop/storage/<?= htmlspecialchars($product['image']) ?>" width="100" height="100"><br>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= htmlspecialchars($product['description']) ?></td>
            <td><?= number_format($product['price'], 2) ?></td>
            <td><?= $product['stock'] ?></td>
            <td><?= htmlspecialchars($product['category_name']) ?></td>
            <td>
                <a href="<?= BASE_URL ?>/products/edit?id=<?= $product['id'] ?>">Edit</a> |
                <form action="<?= BASE_URL ?>/products/delete" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline;">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>
