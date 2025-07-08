<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Category;

$category = new Category($db);

$id = intval($_POST['id']);
$name = trim($_POST['name']);

if (!$id ||!is_numeric($id) || $name === '') {
    $session->flash('error', 'Invalid data.');
    header('Location: ' . BASE_URL . '/categories/edit?id=' . $id);
    exit;
}

$existing = $category->find($id);

if (!$existing) {
    $session->flash('error', 'Category not found.');
    header('Location: ' . BASE_URL . '/categories');
    exit;
}

$success = $category->update($id, $name);

if ($success) {
    $session->flash('success', 'Category successfully updated.');
} else {
    $session->flash('error', 'Category update failed.');
}

header('Location: ' . BASE_URL . '/categories');
exit;