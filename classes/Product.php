<?php
namespace Classes;

class Product {
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function all(): array
    {
        return $this->db->query(
            'SELECT p.*, c.name as category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.created_at DESC'
        )->fetchAll(); 
    }

    public function find(int $id): array|false
    {
        return $this->db->query(
            'SELECT p.*, c.name as category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?',
            [$id]
        )->fetch();
    }

    public function create(string $name, ?string $desc = null, float $price, int $stock, ?string $imagePath = null, int $categoryId): bool
    {
        return $this->db->query(
            'INSERT INTO products (name, description, price, stock, image, category_id)
            VALUES (?, ?, ?, ?, ?, ?)',
            [$name, $desc, $price, $stock, $imagePath, $categoryId]
        )->rowCount() > 0;
    }

    public function update(int $id, string $name, ?string $desc = null, float $price, int $stock, ?string $imagePath = null, int $categoryId): bool
    {
        if ($imagePath) {
            return $this->db->query(
                'UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image = ?, category_id = ?
                WHERE id = ?',
                [$name, $desc, $price, $stock, $imagePath, $categoryId, $id]
            )->rowCount() > 0;
        } else {
            return $this->db->query(
                'UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category_id = ?
                WHERE id = ?',
                [$name, $desc, $price, $stock, $categoryId, $id]
            )->rowCount() > 0;
        }
    }

    public function delete(int $id): bool
    {
        return $this->db->query(
            'DELETE FROM products WHERE id = ?',
            [$id]
        )->rowCount() > 0;
    }

    public function search(string $term): array
    {
        $term = '%' . $term . '%';
        return $this->db->query(
            'SELECT * FROM products
            WHERE name LIKE ? OR description LIKE ?
            ORDER BY created_at DESC',
            [$term, $term]
        )->fetchAll();
    }
}