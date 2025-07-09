<?php
namespace Classes;

class User {
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function all(): array
    {
        return $this->db->query(
            'SELECT * FROM users ORDER BY created_at DESC'
        )->fetchAll();
    }

    public function create(array $data): bool
    {
        $hashedPass = password_hash($data['password'], PASSWORD_DEFAULT); 
        return $this->db->query(
            'INSERT INTO users (username, password, role)
            VALUES (?, ?, ?)',
            [$data['username'], $hashedPass, $data['role']]
        )->rowCount() > 0; 
    }

    public function update(int $id, array $data): bool
    {        
        if ($data['password']) {
            $hashedPass = password_hash($data['password'], PASSWORD_DEFAULT);
            return $this->db->query(
                'UPDATE users SET username = ?, password = ?, role = ?
                WHERE id = ?',
                [$data['username'], $hashedPass, $data['role'], $id]
            )->rowCount() > 0;
        } else {
            return $this->db->query(
                'UPDATE users SET username = ?, role = ?
                WHERE id = ?',
                [$data['username'], $data['role'], $id]
            )->rowCount() > 0;
        }
        
    }

    public function delete(int $id): bool
    {
        return $this->db->query(
            'DELETE FROM users WHERE id = ?',
            [$id]
        )->rowCount() > 0;
    }

    public function usernameExists(string $username, ?int $excludeId = null): bool
    {
        $sql = 'SELECT 1 FROM users where username = ?';
        $params = [$username];

        if ($excludeId !== null) {
            $sql .= 'AND id != ?';
            $params[] = $excludeId;
        }

        return $this->db->query($sql, $params)->fetch() !== false;
    }

    public function find(int $id): array|false
    {
        return $this->db->query(
            'SELECT * FROM users
            WHERE id = ?
            LIMIT 1',
            [$id]
        )->fetch();
    }


}