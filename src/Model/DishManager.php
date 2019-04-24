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
        return $this->pdo->query('SELECT * FROM ' . $this->table)->fetchAll();
    }
}
