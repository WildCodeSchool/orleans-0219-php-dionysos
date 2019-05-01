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
}
