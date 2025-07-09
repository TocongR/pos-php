<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\User;

$user = new User($db);

$id = intval($_POST['id']) ?? null;
$username = trim($_POST['username'] ?? '');
$currentPassword = $_POST['current_password'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? null;

if (!$id || $username === '' || !$role) {
    $session->flash('error', 'Please fill in all required fields.');
    header('Location: ' . BASE_URL . '/users/edit?id=' . $id);
    exit;
}

if ($user->usernameExists($username, $id)) {
    $session->flash('error', 'Username already exists.');
    header('Location: ' . BASE_URL . '/users/edit?id=' . $id);
    exit;
}

$currentUser = $user->find($id);

if (!$currentUser) {
    $session->flash('error', 'User not found.');
    header('Location: ' . BASE_URL . '/users/edit?id=' . $id);
    exit;
}

if ($password !== '') {
    if ($currentPassword === '' || !password_verify($currentPassword, $currentUser['password'])) {
        $session->flash('error', 'Current password incorrect.');
        header('Location: ' . BASE_URL . '/users/edit?id=' . $id);
        exit;  
    }      
}

$data = [
    'username' => $username,
    'password' => $password,
    'role' => $role
];

$success = $user->update($id, $data);

if ($success) {
    $session->flash('success', 'User successfully updated.');
} else {
    $session->flash('error', 'Something went wrong.');
}

header('Location: ' . BASE_URL . '/users');
exit;