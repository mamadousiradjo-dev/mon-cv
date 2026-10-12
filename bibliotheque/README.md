# Mini-bibliothèque — exercice MVC

Le projet affiche déjà deux livres. À toi d'ajouter les autres fonctionnalités en suivant cet exemple, sans tout coder dans un seul fichier.

## 1. Lancer le projet

Il faut **PHP avec PDO SQLite**. Depuis la racine du dépôt, entre dans le dossier de l’exercice :

```sh
cd bibliotheque
php bin/setup.php
php -S 127.0.0.1:8001 -t public public/index.php
```

Ouvre <http://127.0.0.1:8001/>. `setup.php` crée la base et deux livres d'exemple ; tu peux le relancer sans créer de doublons. Arrête le serveur avec `Ctrl+C`.

## 2. Comprendre l'exemple

La page d'accueil fonctionne déjà. Suis son chemin dans le code :

`GET /` dans `public/index.php` → `BookController::index()` → `BookRepository::all()` → objets `Book` → `app/View/books.php`.

Le **contrôleur** reçoit la requête et choisit quoi faire. Le **modèle** porte les données et les règles d'un livre. Le **repository** parle à SQLite. La **vue** affiche le HTML.

## 3. Ce que tu dois réaliser

Fais les exercices dans cet ordre :

1. **Ajouter un livre** : créer le formulaire, valider le titre et l'auteur, enregistrer le livre, puis revenir à la liste. Méthodes à compléter : `Book::validate()`, `BookRepository::create()`, `BookController::form()` et `BookController::create()`.
2. **Emprunter un livre** : retrouver le livre et refuser l'emprunt s'il est déjà emprunté. Méthodes : `BookRepository::find()`, `Book::canBorrow()`, `BookRepository::setBorrowed()` et `BookController::borrow()`.
3. **Rendre un livre** : retrouver le livre et le rendre disponible. Méthode : `BookController::returnBook()` ; réutilise les méthodes du repository.

Pour chaque exercice, ajoute aussi la **route** dans `public/index.php` et le **formulaire ou lien** nécessaire dans `app/View/`. Une route `GET` affiche une page ; une route `POST` traite une modification. Les `TODO` et les `LogicException` indiquent les parties que tu dois remplacer par ton code.

Avance une fonctionnalité à la fois. Vérifie le résultat dans le navigateur, puis essaie aussi un cas invalide : titre vide, livre introuvable ou livre déjà emprunté. Affiche les textes venant de la base avec `htmlspecialchars()`.

## 4. Créer une nouvelle page

Le header et le footer sont déjà prêts dans `app/View/partials/`. Dans une nouvelle vue placée dans `app/View/`, écris seulement son contenu entre les deux inclusions :

```php
<?php
$pageTitle = 'Ajouter un livre';
require __DIR__ . '/partials/header.php';
?>
<h1>Ajouter un livre</h1>
<!-- Ton formulaire ici -->
<?php require __DIR__ . '/partials/footer.php'; ?>
```

Regarde `app/View/books.php` pour voir un exemple complet. Le header ouvre `<main>` et le footer le ferme : ne les recrée pas dans chaque page.

## 5. Modifier le style avec Tailwind

Le CSS est déjà généré : **Node.js n'est pas nécessaire pour lancer le site**. Si tu changes les classes Tailwind dans une vue PHP, installe les dépendances une fois :

```sh
npm ci --prefix assets
```

Puis reconstruis le CSS après tes changements :

```sh
npm run build:css --prefix assets
```

Le fichier source est `assets/css/input.css` ; le résultat servi au navigateur est `public/output.css`. Pour reconstruire automatiquement, lance `npm run dev:css --prefix assets` dans un deuxième terminal.
