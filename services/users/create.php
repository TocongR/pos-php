<?php
require_once __DIR__ . '/../../includes/bootstrap.php';

use Classes\User;

$user = new User($db);

$username = trim($_POST['username']);
$password = $_POST['password'];
$role = $_POST['role'];

if ($username === '' || $password === '' || $role === '') {
    $session->flash('error', 'Please fill in all required fields.');
    header('Location: ' . BASE_URL . '/users/create');
    exit;
}

if ($user->usernameExists($username)) {
    $session->flash('error', 'Username already exists');
    header('Location: ' . BASE_URL . '/users/create');
    exit;
}

$data = [
    'username' => $username,
    'password' => $password,
    'role' => $role
];

$success = $user->create($data);

if ($success) {
    $session->flash('success', 'User successfully created.'); 
} else {
    $session->flash('error', 'Something went wrong.');
}

header('Location: ' . BASE_URL . '/users');
exit;