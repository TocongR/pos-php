<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if ($auth->isLoggedIn()) {
    header('Location: ' . BASE_URL . '/dashboard');
    exit;
}
?>
<h1>Login</h1>
<?php if ($session->hasFlash('error')): ?>
    <p><?= $session->getFlash('error') ?></p>
<?php endif; ?>
<form method="post" action="<?= BASE_URL ?>/login">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Sign In</button>
</form>
<a href="<?= BASE_URL ?>/register">Register</a>