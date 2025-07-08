<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\Category;

$category = new Category($db);

$id = intval($_POST['id']);

if (!$id ||!is_numeric($id)) {
    $session->flash('error', 'Invalid data.');
    header('Location: ' . BASE_URL . '/categories');
    exit;
}

$existing = $category->find($id);

if (!$existing) {
    $session->flash('error', 'Category not found.');
    header('Location: ' . BASE_URL . '/categories');
    exit;
}

$success = $category->delete($id);

if ($success) {
    $session->flash('success', 'Category successfully updated.');
} else {
    $session->flash('error', 'Category delete failed.');
}

header('Location: ' . BASE_URL . '/categories');
exit;