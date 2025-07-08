<?php
namespace Classes;

class Category {
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function all(): array
    {
        return $this->db->query(
            'SELECT * FROM categories ORDER BY created_at DESC'
        )->fetchAll();
    }

    public function find(int $id): array|false
    {
        return $this->db->query(
            'SELECT * FROM categories WHERE id = ?',
            [$id]
        )->fetch();
    }

    public function create(string $name): bool
    {
        return $this->db->query(
            'INSERT INTO categories (name) VALUES (?)',
            [$name]
        )->rowCount() > 0;
    }

    public function update(int $id, string $name): bool
    {
        return $this->db->query(
            'UPDATE categories SET name = ? WHERE id = ?',
            [$name, $id]
        )->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        return $this->db->query(
            'DELETE FROM categories WHERE id = ?',
            [$id]
        )->rowCount() > 0;
    }

    public function search(string $term): array
    {
        $term = '%' . $term . '%';
        return $this->db->query(
            'SELECT * FROM categories
            WHERE name LIKE ?
            ORDER BY created_at DESC',
            [$term]
        )->fetchAll();
    }
}