<?php


namespace App\Model;

/**
 *
 */
class MenuManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'menu';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
