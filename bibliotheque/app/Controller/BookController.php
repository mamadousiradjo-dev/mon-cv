<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\BookRepository;

final class BookController
{
    public function __construct(private readonly BookRepository $books) {}

    public function index(): void
    {
        // Exemple complet : le contrôleur demande les données et choisit la vue.
        $books = $this->books->all();
        require dirname(__DIR__) . '/View/books.php';
    }

    /** Afficher le formulaire d'ajout à créer dans app/View/. */
    public function form(): void
    {
        // TODO élève : afficher la vue du formulaire.
        throw new \LogicException('Formulaire à implémenter.');
    }

    /** Lire le POST, valider le modèle, enregistrer et rediriger vers /. */
    public function create(): void
    {
        // TODO élève : utiliser Book::validate() et BookRepository::create().
        throw new \LogicException('Ajout à implémenter.');
    }

    /** Refuser un second emprunt du même livre, sinon le marquer emprunté. */
    public function borrow(): void
    {
        // TODO élève : utiliser find(), canBorrow() et setBorrowed().
        throw new \LogicException('Emprunt à implémenter.');
    }

    /** Rendre un livre emprunté, puis rediriger vers /. */
    public function returnBook(): void
    {
        // TODO élève : utiliser find() et setBorrowed().
        throw new \LogicException('Retour à implémenter.');
    }
}
