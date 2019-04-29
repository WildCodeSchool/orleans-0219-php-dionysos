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
class AdminReviewManager extends AbstractManager
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
    /**
     * Get all row from database, ordered by asc.
     *
     * @return array
     */
    public function selectAllAdminReviews(): array
    {
        return $this->pdo->query('SELECT * FROM ' . self::TABLE . ' ORDER BY id DESC')->fetchAll();
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * @param int $id int $online
     * @return bool
     */
    public function online(int $id, int $online)
    {
        // prepared request

        $statement = $this->pdo->prepare("UPDATE $this->table SET `online` = :online WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        if ($online == 1 ) {
            $statement->bindValue('online', 0, \PDO::PARAM_STR);
        } else {
            $statement->bindValue('online', 1, \PDO::PARAM_STR);
        }
        return $statement->execute();
    }
}
