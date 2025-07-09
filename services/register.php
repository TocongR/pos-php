<?php
// require_once __DIR__ . '/../includes/bootstrap.php';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if ($auth->register($_POST['username'], $_POST['password'])) {
//         if ($auth->login($_POST['username'], $_POST['password'])) {
//             header('Location: ' . BASE_URL . '/dashboard');
//             exit;
//         }
//     } else {
//         $session->flash('error', 'Username is already taken.');
//         header('Location: ' . BASE_URL . '/register');
//         exit;
//     }
// }