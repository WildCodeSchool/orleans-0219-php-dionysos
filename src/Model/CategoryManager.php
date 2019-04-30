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

}
