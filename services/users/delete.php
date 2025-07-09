<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\User;

$user = new User($db);

$id = intval($_POST['id']);

if (!$id ||!is_numeric($id)) {
    $session->flash('error', 'Invalid data.');
    header('Location: ' . BASE_URL . '/users');
    exit;
}

$existing = $user->find($id);

if (!$existing) {
    $session->flash('error', 'Category not found.');
    header('Location: ' . BASE_URL . '/categories');
    exit;
}

$success = $user->delete($id);

if ($success) {
    $session->flash('success', 'User successfully updated.');
} else {
    $session->flash('error', 'User delete failed.');
}

header('Location: ' . BASE_URL . '/users');
exit;