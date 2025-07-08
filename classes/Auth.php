<?php
namespace Classes;

class Auth {
    private Database $db;
    private Session $session;

    public function __construct(Database $db, Session $session)
    {
        $this->db = $db;
        $this->session = $session;
    }

    public function register(string $username, string $password, string $role = 'user'): bool
    {
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        $existUsername = $this->db->query(
            'SELECT id FROM users WHERE username = ?', 
            [$username]
        )->fetch();

        if ($existUsername) {
            return false;
        }

        return $this->db->query(
            'INSERT INTO users (username, password, role) VALUES (?, ?, ?)', 
            [$username, $hashedPass]
        )->rowCount() > 0;
    }

    public function login(string $username, string $password): bool
    {
        $user = $this->db->query(
            'SELECT * FROM users WHERE username = ? LIMIT 1', 
            [$username]
        )->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $this->session->regenerate();
            $this->session->set('user_id', $user['id']);
            $this->session->set('user_name', $user['username']);
            $this->session->set('user_role', $user['role']);
            return true;
        }
        
        return false;
    }

    public function logout(): void
    {
        $this->session->destroy();
    }

    public function isLoggedIn(): bool
    {
        return $this->session->has('user_id');
    }

    public function requireLogin(string $redirectTo = '/inv_sys_php_oop/public/login') {
        if (!$this->isLoggedIn()) {
            header("Location: $redirectTo");
            exit;
        }
    }

    public function getUserRole(): ?string
    {
        return $this->session->get('user_role');
    }

    public function hasRole(string $role): ?bool
    {
        return $this->getUserRole() === $role;
    }

    public function requireRole(string $role, string $redirectTo = '/inv_sys_php_oop/public/login'): void
    {
        $this->requireLogin($redirectTo);

        if (!$this->hasRole($role)) {
            $this->session->set('error', 'You are not authorized to access this page');
            header('Location: ' . $redirectTo);
            exit;
        }
    }
}