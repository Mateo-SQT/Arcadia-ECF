<?php
namespace App\Service;

use PDO;

class AnimalDataService
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getRaces(): array
    {
        $statement = $this->pdo->query('SELECT * FROM race');
        return $statement->fetchAll();
    }

    public function getHabitats(): array
    {
        $statement = $this->pdo->query('SELECT * FROM habitat');
        return $statement->fetchAll();
    }
}

