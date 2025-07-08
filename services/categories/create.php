<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Category;

$category = new Category($db);

$name = trim($_POST['name'] ?? '');

if ($name === '') {
    $session->flash('error', 'Name is required.');
    header('Location: ' . BASE_URL . '/categories/create');
    exit;
}

$success = $category->create($name);

if ($success) {
    $session->flash('success', 'Category successfully created.');
} else {
    $session->flash('error', 'Something went wrong.');
}

header('Location: ' . BASE_URL . '/categories');
exit;