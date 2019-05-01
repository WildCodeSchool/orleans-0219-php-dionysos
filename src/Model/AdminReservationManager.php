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
        return $this->pdo->query('SELECT * FROM ' . self::TABLE . ' ORDER BY date')->fetchAll();
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * @param int $reservation
     * @return bool
     */
    public function updateValidate(int $reservation):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `validate` = 1 WHERE id=:id");
        $statement->bindValue(':validate', $reservation['validate'], \PDO::PARAM_INT);
        return $statement->execute();
    }
}
