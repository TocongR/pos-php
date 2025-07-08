<?php
require_once '../includes/bootstrap.php';

$request = $_SERVER['REQUEST_URI'];
$base = '/inv_sys_php_oop/public/';
$url_parts = parse_url($request);
$path = trim(str_replace($base, '', $url_parts['path']), '/');
$method = $_SERVER['REQUEST_METHOD'];

$routes = [
    'GET' => [
        '' => '../pages/home.php',
        'login' => '../pages/login.php',
        'register' => '../pages/register.php',
        'logout' => '../services/logout.php',
        'admin/dashboard' => '../pages/admin/dashboard.php',
        'manager/dashboard' => '../pages/manager/dashboard.php',
        'products' => '../pages/products/index.php',
        'products/create' => '../pages/products/create.php',
        'products/edit' => '../pages/products/edit.php',
        'categories' => '../pages/categories/index.php',
        'categories/create' => '../pages/categories/create.php',
        'categories/edit' => '../pages/categories/edit.php',
        'sales' => '../pages/sales/index.php',
        'orders' => '../pages/orders/index.php',
        'orders/view' => '../pages/orders/view.php'
    ],
    'POST' => [
        'login' => '../services/login.php',
        'register' => '../services/register.php',
        'products/create' => '../services/products/create.php',
        'products/edit' => '../services/products/edit.php',
        'products/delete' => '../services/products/delete.php',
        'categories/create' => '../services/categories/create.php',
        'categories/edit' => '../services/categories/edit.php',
        'categories/delete' => '../services/categories/delete.php',
        'sales/add-item' => '../services/sales/add_item.php',
        'sales/remove-item' => '../services/sales/remove_item.php',
        'sales/checkout' => '../services/sales/checkout.php'
    ]
];

$accessControl = [
    'public' => [
        'GET' => ['', 'login', 'register'],
        'POST' => ['login', 'register']
    ],
    'roles' => [
        'GET' => [
            'admin/dashboard' => ['admin'],
            'manager/dashboard' => ['manager'],
            'products' => ['admin', 'manager'],
            'products/create' => ['admin', 'manager'],
            'products/edit' => ['admin', 'manager'],
            'products/delete' => ['admin'],
            'categories' => ['admin', 'manager'],
            'categories/create' => ['admin', 'manager'],
            'categories/edit' => ['admin', 'manager'],
            'sales'  => ['admin', 'manager', 'cashier'],
            'orders'  => ['admin', 'manager', 'cashier'],
            'orders/view'  => ['admin', 'manager', 'cashier'],
        ],
        'POST' => [
            'products/create' => ['admin', 'manager'],
            'products/edit' => ['admin', 'manager'],
            'products/delete' => ['admin'],
            'categories/create' => ['admin', 'manager'],
            'categories/edit' => ['admin', 'manager'],
            'categories/delete' => ['admin', 'manager'],
            'sales/add-item' => ['admin', 'manager', 'cashier'],
            'sales/remove-item' => ['admin', 'manager', 'cashier'],
            'sales/checkout' => ['admin', 'manager', 'cashier']
        ]
    ]
];



if (isset($routes[$method][$path])) {
    $isPublicRoute = in_array($path, $accessControl['public'][$method] ?? []);

    if (!$isPublicRoute) {
        $auth->requireLogin();

        if (isset($accessControl['roles'][$method][$path])) {
            $userRole = $auth->getUserRole();

            if (!in_array($userRole, $accessControl['roles'][$method][$path])) {
                http_response_code(403);
                echo 'You are not authorized to access this page';
                exit;
            }
        }
    }
    require $routes[$method][$path];
} else {
    http_response_code(404);
    echo '404 Not Found';
}