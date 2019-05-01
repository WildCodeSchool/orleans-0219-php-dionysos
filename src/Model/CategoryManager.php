<?php


namespace App\Model;

/**
 *
 */

class CategoryManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'dish_types';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM ' . self::TABLE . ' ORDER BY display_order ASC')->fetchAll();
    }

    /**
     * @param array $review
     * @return int
     */
    public function insert(array $review): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, price, label) 
        VALUES (:name, :price, :label)");
        $statement->bindValue(':name', $review['name'], \PDO::PARAM_STR);
        $statement->bindValue(':price', $review['price'], \PDO::PARAM_STR);
        $statement->bindValue(':label', $review['label'], \PDO::PARAM_STR);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
