<?php


namespace App\Model;

/**
 *
 */
class DishManager extends AbstractManager
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


    public function selectDish(): array
    {
        return $this->pdo->query('SELECT dish.*, dish_types.id 
        as dish_type_id, dish_types.name, dish_types.price FROM ' . $this->table . ' 
        RIGHT JOIN dish_types ON dish.category = dish_types.id')->fetchAll();
    }

    public function insert(array $dish): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (id, dish_name, category, sup) 
            VALUES (:id, :dish_name, :category, :sup)");
        $statement->bindValue('dish_name', $dish['dish_name'], \PDO::PARAM_STR);
        $statement->bindValue('category', $dish['category'], \PDO::PARAM_STR);
        $statement->bindValue('sup', $dish['sup'], \PDO::PARAM_STR);
        $statement->bindValue('id', $dish['id'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
