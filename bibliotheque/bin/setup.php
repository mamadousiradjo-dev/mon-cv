<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit(1);
}

$database = new PDO('sqlite:' . dirname(__DIR__) . '/data/books.sqlite');
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$database->exec('CREATE TABLE IF NOT EXISTS books (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    author TEXT NOT NULL,
    borrowed INTEGER NOT NULL DEFAULT 0
)');

if ((int) $database->query('SELECT COUNT(*) FROM books')->fetchColumn() === 0) {
    $insert = $database->prepare('INSERT INTO books (title, author) VALUES (?, ?)');
    $insert->execute(['Le Petit Prince', 'Antoine de Saint-Exupéry']);
    $insert->execute(['Une si longue lettre', 'Mariama Bâ']);
}

echo "Bibliothèque prête.\n";
