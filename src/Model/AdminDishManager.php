<?php


namespace App\Model;

/**
 *
 */
class AdminDishManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'dish';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $dish
     * @return int
     */

    public function insert(array $dish): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (dish_name, category, sup) 
            VALUES (:dish_name, :category, :sup)");
        $statement->bindValue('dish_name', $dish['dish_name'], \PDO::PARAM_STR);
        $statement->bindValue('category', $dish['category'], \PDO::PARAM_STR);
        $statement->bindValue('sup', $dish['sup'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
