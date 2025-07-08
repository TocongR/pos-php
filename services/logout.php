<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$auth->logout();
header('Location: ' . BASE_URL . '/login');
exit;
