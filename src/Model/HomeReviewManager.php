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
class HomeReviewManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'review';
    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectHomeReviews(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table .' 
        WHERE rating > 3 
        AND online = 1 
        ORDER BY RAND() 
        LIMIT 3') -> fetchAll();
    }
}
