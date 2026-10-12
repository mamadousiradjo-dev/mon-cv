<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;
use PDOException;

final class DbConnection
{
    public static function connect(): ?PDO
    {
        $database = getenv('DB_NAME');
        if ($database === false || $database === '') {
            return null;
        }

        try {
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $port = getenv('DB_PORT') ?: '3306';

            return new PDO(
                "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
                getenv('DB_USER') ?: '',
                getenv('DB_PASSWORD') ?: '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $exception) {
            error_log('Connexion MySQL impossible : ' . $exception->getMessage());
            return null;
        }
    }
}
