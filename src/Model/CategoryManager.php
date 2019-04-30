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
     * online from 0 to 1 or 1 to 0
     * @param array $data
     * @return bool
     */
    public function updateLabel(array $data):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `label` = !`label` WHERE id=:label");
        $statement->bindValue(':label', $data['label'], \PDO::PARAM_INT);
        return $statement->execute();
    }
}
