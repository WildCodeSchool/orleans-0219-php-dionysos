<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class DrinkManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'drink';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @return array
     */
    public function selectAllWithCategories(): array
    {
        return $this->pdo->query('SELECT d.*, dt.name as category FROM ' . $this->table. ' d
        JOIN drink_type dt ON dt.id=d.drink_type_id ORDER BY name ASC')->fetchAll();
    }


  public function insert(array $data): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
                                                (`name`, `main_price`, `takeaway_price`, `is_organic`, `drink_type_id`) 
                                         VALUES (:name, :main_price, :takeaway_price, :is_organic, :drink_type_id);");
        $statement->bindValue('name', $data['name'], \PDO::PARAM_STR);
        $statement->bindValue('main_price', $data['main_price']);
        $statement->bindValue('takeaway_price', $data['takeaway_price']);
        $statement->bindValue('is_organic', $data['is_organic']);
        $statement->bindValue('drink_type_id', $data['drink_type_id'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
