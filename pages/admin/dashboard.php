<?php
require_once __DIR__ . '/../../includes/bootstrap.php'
?>

<body>
    Hello Admin
    <a href="<?= BASE_URL ?>/products">Products</a>
    <a href="<?= BASE_URL ?>/categories">Category</a>
    <a href="<?= BASE_URL ?>/products">Supplier</a>
    <a href="<?= BASE_URL ?>/sales">POS</a>
    <a href="<?= BASE_URL ?>/orders">Orders/Transactions</a>
    <a href="<?= BASE_URL ?>/logout">Logout</a>
</body>