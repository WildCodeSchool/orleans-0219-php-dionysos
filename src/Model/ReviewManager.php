<?php

namespace App\Model;

class BookManager extends AbstractManager
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
     * @param array $review
     * @return int
     */
    public function insert(array $review): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (name, comment, rating) VALUES (:name, :comment, :rating))");
        $statement->bindValue('name', $review['name'], \PDO::PARAM_STR);
        $statement->bindValue('comment', $review['comment'], \PDO::PARAM_STR);
        $statement->bindValue('rating', $review['rating'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
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
     * @param array $item
     * @return bool
     */
    public function update(array $item):bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $item['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    private function formErrors(array $userData): array
    {
        $errors = [];
        if (!isset($data['name']) || strlen($userData['name']) < self::MIN_TITLE_LENGTH) {
            $errors['title_length'] = "Le titre doit contenir minimum " . self::MIN_TITLE_LENGTH . " caractères !";
        }
        if (!isset($data['comment']) || strlen($userData['comment']) < self::MIN_CONTENT_LENGTH) {
            $errors['content_length'] =
                "Le contenu doit contenir minimum " . self::MIN_CONTENT_LENGTH . " caractères !";
        }
        if (count($errors) !== 0) {
            $errors['title'] = $userData['title'];
            $errors['content'] = $userData['content'];
        }
        return $errors;
    }
}
