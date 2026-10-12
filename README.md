# CV de Mamadou Siradjo Baldé

Une application PHP **MVC avec Repository** : les contrôleurs traitent les requêtes, les modèles représentent les données, les repositories valident et enregistrent les données dans MySQL, et les vues PHP produisent les pages HTML. Le site utilise un seul serveur et un seul port. Le CV reste visible avec ses données de secours si MySQL est arrêté.

## Démarrage local

Prérequis : PHP 8.1+ avec PDO MySQL et fileinfo, et Docker Compose. Node.js/npm sert uniquement à modifier les styles.

```sh
docker compose up -d --wait db
DB_HOST=127.0.0.1 DB_PORT=3307 DB_NAME=mon_cv DB_USER=mon_cv DB_PASSWORD=mon_cv_local_test php bin/setup.php
DB_HOST=127.0.0.1 DB_PORT=3307 DB_NAME=mon_cv DB_USER=mon_cv DB_PASSWORD=mon_cv_local_test php -S 127.0.0.1:8000 -t public public/router.php
```

Ouvrir <http://127.0.0.1:8000>. Le dossier `public/` est le seul dossier exposé au navigateur : les modèles, les vues et les scripts CLI restent en dehors de cette racine web. Les photos envoyées sont publiques sous `/uploads/`. `public/router.php` laisse PHP servir directement le CSS et les images, puis transmet les autres requêtes à `public/index.php`.

## Organisation MVC + Repository

- `app/Model/` : données du CV et des utilisateurs, sans requête SQL ni HTML.
- `app/Repository/` : `DbConnection.php` ouvre MySQL ; les autres repositories valident les entrées, puis chargent et enregistrent les données avec des requêtes préparées.
- `app/Controller/` : routage des actions, session, réponses HTTP et droits d'accès.
- `app/View/` : pages HTML/PHP, navigation partagée et échappement des données avant affichage.
- `public/` : point d'entrée, routeur, CSS et images publiques.
- `assets/` : sources Tailwind et dépendances Node locales au dossier.
- `bin/` : commandes réservées au terminal.
- `public/uploads/` : photos envoyées, ignorées par Git et accessibles directement par URL. Le contrôleur vérifie leur format avant de les enregistrer.

Chemin d’une requête : `public/index.php` → contrôleur → repository → modèle → vue. `bin/` ne contient que les commandes terminal ; le site web ne charge pas de fichier depuis ce dossier.

Les routes des pages sont `/`, `/projets`, `/contact`, `/inscription`, `/connexion` et `/utilisateurs`. Les formulaires utilisent `POST` et un jeton CSRF stocké en session. Les pages sont rendues sur le serveur ; aucun JavaScript n'est requis pour l'authentification.

## Comptes et droits

L'inscription crée un compte standard avec un mot de passe haché. Après s'être inscrit, le propriétaire active son rôle depuis le terminal :

```sh
DB_HOST=127.0.0.1 DB_PORT=3307 DB_NAME=mon_cv DB_USER=mon_cv DB_PASSWORD=mon_cv_local_test php bin/promote_admin.php son-adresse@example.com
```

Il suffit ensuite de recharger la page. Seul le propriétaire peut voir les utilisateurs inscrits et changer la photo du CV. Le navigateur ne peut pas demander le rôle propriétaire. Les mots de passe hachés ne sont jamais transmis aux vues. La photo doit être un JPG, PNG ou WebP de 5 Mo maximum. Toute photo envoyée devient accessible publiquement via son URL aléatoire.

## Modifier les styles

```sh
cd assets
npm ci
npm run build:css
```

`public/output.css` est versionné : Node.js n'est pas nécessaire pour afficher le site. `npm run dev:css` reconstruit le CSS lors des modifications. Les dépendances restent dans `assets/node_modules/`, jamais à la racine du dépôt.

## Base de test et publication

MySQL n'est exposé que sur `127.0.0.1:3307`. Les identifiants du Compose sont réservés au développement local. `docker compose down` arrête la base sans effacer le volume ; `docker compose down -v` efface les données de test.

GitHub Pages ne lance pas PHP : il faut un hébergement PHP/MySQL pour publier l'application. Avant une mise en production, utiliser HTTPS, des identifiants MySQL distincts et une limitation des tentatives de connexion. L'envoi de messages reste un exercice futur.

## Exercice pour l’élève : ajouter une expérience

Le squelette est prêt. Connecte-toi comme propriétaire, puis ouvre `/experiences/ajouter`. Le formulaire s'affiche ; son envoi retourne volontairement **501** tant que l'exercice n'est pas terminé. Ne retire pas les vérifications du propriétaire et du jeton CSRF.

À compléter dans cet ordre :

1. `app/Model/ExperienceModel.php` — implémenter `validate()` : `title`, `company` et `period` obligatoires après `trim()`, longueurs compatibles avec la table (`255`, `255`, `100`) ; limiter aussi la description. Lever `InvalidArgumentException` si une valeur est invalide.
2. `app/Repository/ExperienceRepository.php` — implémenter `create()` avec un `INSERT` préparé et `all()` avec un `SELECT` de toutes les lignes. Utiliser les colonnes existantes : `titre`, `entreprise`, `periode`, `description`.
3. `app/Controller/ExperienceController.php` — remplacer la réponse 501 : lire les champs du formulaire, créer le modèle, appeler `validate()` puis `create()`. En cas d'erreur de validation, afficher le message dans le formulaire ; après réussite, rediriger vers `/`.
4. `app/Repository/CvRepository.php`, `app/Model/CvModel.php` et `app/View/home.php` — remplacer l'expérience unique par une liste pour afficher toutes les expériences enregistrées. Garder une valeur de secours quand MySQL n'est pas disponible.
5. Ajouter un lien vers le formulaire visible seulement par le propriétaire, puis tester : visiteur refusé, compte standard refusé, jeton CSRF invalide refusé, champs vides refusés, expérience valide affichée sur l'accueil.

La table `experiences` existe déjà après `php bin/setup.php` : aucune migration n'est nécessaire pour cet exercice. Le format de la période est du texte libre (`2025–2026`) ; il n'y a donc pas de comparaison de dates à inventer.
