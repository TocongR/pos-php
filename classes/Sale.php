<?php
namespace Classes;

class Sale {
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int|false
    {
        $stmt = $this->db->query(
            'INSERT INTO sales (user_id, total, payment_method, amount_paid, `change`)
            VALUES (?, ?, ?, ?, ?)',
            [$data['user_id'], $data['total'], $data['payment_method'], $data['amount_paid'], $data['change']]
        );

        if ($stmt->rowCount() > 0) {
            return intval($this->db->lastInsertId());
        }

        return false;
    }

    public function addItems(int $saleId, array $cart): bool
    {
        if (empty($cart)) {
            return false;
        }

        foreach ($cart as $id => $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $result = $this->db->query(
                'INSERT INTO sales_items (sale_id, product_id, quantity, price, subtotal)
                VALUES (?, ?, ?, ?, ?)',
                [$saleId, $item['id'], $item['quantity'], $item['price'], $subtotal]
            );

            $this->db->query(
                'UPDATE products SET stock = stock - ? WHERE id = ?',
                [$item['quantity'], $id]
            );
        }

        if ($result->rowCount() <= 0) {
            return false;
        }

        return true;
        
    }
}
