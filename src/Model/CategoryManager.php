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
     * @param array $category
     * @return int
     */
    public function insert(array $category): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, price, label, display_order) 
        VALUES (:name, :price, :label, :display_order)");
        $statement->bindValue(':name', $category['name'], \PDO::PARAM_STR);
        $statement->bindValue(':display_order', $category['display_order'], \PDO::PARAM_STR);
        $statement->bindValue(':price', $category['price'], \PDO::PARAM_INT);
        $statement->bindValue(':label', $category['label'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * @param string $display_order
     * @return void
     */
    public function changeOrder(string $display_order): void
    {
        $statement = $this->pdo->prepare("UPDATE $this->table SET display_order = display_order + 1 
        WHERE display_order > display_order=:display_order");
        $statement->bindValue(':display_order', $display_order, \PDO::PARAM_STR);
        $statement->execute();
    }
}
