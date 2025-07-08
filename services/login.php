<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($auth->login($_POST['username'], $_POST['password'])) {
        $roleRedirects = [
            'admin' => '/admin/dashboard',
            'manager' => '/manager/dashboard',
            'user' => '/products'
        ];

        $role = $auth->getUserRole();
        $redirectPath = $roleRedirects[$role] ?? '/products';

        header('Location: ' . BASE_URL . $redirectPath);
        exit;
    }

    $session->flash('error', 'Invalid credentials');
    header('Location: ' . BASE_URL . '/login');
    exit;
}
