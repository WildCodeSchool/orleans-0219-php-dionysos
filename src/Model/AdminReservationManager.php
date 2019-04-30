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
class AdminReservationManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'reservation';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get all row from database, ordered by asc.
     *
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM ' . self::TABLE . ' ORDER BY id DESC')->fetchAll();
    }

    /**
     * online from 0 to 1 or 1 to 0
     *@param array $data
     * @return bool
     */
    public function updateStatus(array $data):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `online` = !`online` WHERE id=:online");
        $statement->bindValue(':online', $data['online'], \PDO::PARAM_INT);
        return $statement->execute();
    }
}
