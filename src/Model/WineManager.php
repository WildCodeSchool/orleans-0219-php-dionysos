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
class WineManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'wine';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectWine(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table . ' 
        RIGHT JOIN wine_type ON wine.type = wine_type.id')->fetchAll();
    }
}
