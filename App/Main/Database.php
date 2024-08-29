<?php

namespace App\Main;

use PDO;
use App\Elements\Charity;

class Database
{
    private $pdo;

    public function __construct(){
        $host = 'localhost';
        $db   = 'fundraiser';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES   => false,
                ];
        $this->pdo = new PDO($dsn, $user, $pass, $options);
    }

    public function createCharity(string $name, string $email): void{
       
        $sql = "
            INSERT INTO `charities` (name, email)
            VALUES (?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $email]);
    }

    public function updateCharity(int $id, string $name, string $email): bool{

        $sql = "
        UPDATE `charities`
        SET name = ?, email = ?
        WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $email, $id]);
    }

    public function addDonation(int $charityId, string $name, int $amount, string $dateTime): bool{

        $sql = "
        INSERT INTO `donations` (charity_id, name, amount, date)
        VALUES (?, ?, ?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$charityId, $name, $amount, $dateTime]);
    }

    public function deleteCharity(int $id): bool{

        $sql = "
        DELETE FROM `charities`
        WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function showCharity(int $id): ?Charity{

        $sql = "
        SELECT *
        FROM `charities`
        WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        $response =  $stmt->fetch();
        if($response){
            return new Charity($response->name, $response->email, $id);
        }

        return null;
    }

    public function showAllCharities(): array{
        $sql = "
        SELECT *
        FROM `charities`
        ";

        $stmt = $this->pdo->query($sql);
        
        $response =  $stmt->fetchAll();
        $items = [];
        foreach($response as $item){
            $items[] = new Charity($item->name, $item->email, $item->id);
        }
        return $items;
    }
}