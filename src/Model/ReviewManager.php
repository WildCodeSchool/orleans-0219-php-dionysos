<?php

namespace App\Model;

class ReviewManager extends AbstractManager
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
    public function selectAllReviews(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table .' WHERE LENGTH(name) < 25 
        AND LENGTH(comment) < 110 AND online = 1 ORDER BY id DESC')->fetchAll();
    }


    /**
     * @param array $review
     * @return int
     */
    public function insert(array $review): int
    {
        // prepared request
        $date = date("d/m/Y");
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, date, comment, rating, online) 
        VALUES (:name, :date, :comment, :rating, :online)");
        $statement->bindValue(':name', $review['name'], \PDO::PARAM_STR);
        $statement->bindValue(':comment', $review['comment'], \PDO::PARAM_STR);
        $statement->bindValue(':rating', $review['rating'], \PDO::PARAM_STR);
        $statement->bindValue(':date', $date, \PDO::PARAM_STR);
        $statement->bindValue(':online', 1, \PDO::PARAM_STR);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
