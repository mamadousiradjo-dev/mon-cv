<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Book;
use PDO;

final class BookRepository
{
    public function __construct(private readonly PDO $database) {}

    /** @return Book[] */
    public function all(): array
    {
        // Exemple complet : SQL -> lignes -> modèles.
        $rows = $this->database->query('SELECT id, title, author, borrowed FROM books ORDER BY id')->fetchAll();
        return array_map(
            static fn (array $row): Book => new Book(
                (int) $row['id'], $row['title'], $row['author'], (bool) $row['borrowed'],
            ),
            $rows,
        );
    }

    /** Enregistrer un nouveau livre et retourner son identifiant. */
    public function create(Book $book): int
    {
        // TODO élève : INSERT préparé, puis lastInsertId().
        throw new \LogicException('Enregistrement à implémenter.');
    }

    /** Trouver un livre par son identifiant, ou retourner null. */
    public function find(int $id): ?Book
    {
        // TODO élève : SELECT préparé, puis créer un Book si trouvé.
        throw new \LogicException('Recherche à implémenter.');
    }

    /** Changer l'état emprunté/disponible d'un livre. */
    public function setBorrowed(int $id, bool $borrowed): void
    {
        // TODO élève : UPDATE préparé.
        throw new \LogicException('Mise à jour à implémenter.');
    }
}
