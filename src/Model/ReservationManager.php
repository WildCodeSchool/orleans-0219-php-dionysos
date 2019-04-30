<?php
namespace App\Model;

class ReservationManager extends AbstractManager
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
     * @param array $reservation
     * @return int
     */
    public function insert(array $reservation): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (name, email, phone, date, nbPeople, appointment) 
        VALUES (:name, :email, :phone, :date, :nbPeople, :appointment)");
        $statement->bindValue(':name', $reservation['name'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $reservation['email'], \PDO::PARAM_STR);
        $statement->bindValue(':phone', $reservation['phone'], \PDO::PARAM_STR);
        $statement->bindValue(':date', $reservation['date'], \PDO::PARAM_STR);
        $statement->bindValue(':nbPeople', $reservation['nbPeople'], \PDO::PARAM_STR);
        $statement->bindValue(':appointment', $reservation['appointment'], \PDO::PARAM_STR);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
