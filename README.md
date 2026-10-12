# CV de Mamadou Siradjo Baldé

Le dépôt contient deux projets séparés :

- **`backend/`** : API PHP en architecture **MC** (Modèle + Contrôleur), sans vues HTML.
- **`frontend/`** : pages du CV, images, JavaScript et Tailwind CSS. C'est le projet de vue distinct.

La base MySQL de test se lance avec `compose.yaml` à la racine. Le site reste lisible si le backend ou MySQL est arrêté.

## Démarrage local

Prérequis : PHP 8.0+, Docker Compose et, pour modifier les styles, Node.js/npm.

```sh
docker compose up -d --wait db
DB_HOST=127.0.0.1 DB_PORT=3307 DB_NAME=mon_cv DB_USER=mon_cv DB_PASSWORD=mon_cv_local_test php backend/bin/setup.php
```

Dans deux terminaux distincts à la racine du dépôt :

```sh
DB_HOST=127.0.0.1 DB_PORT=3307 DB_NAME=mon_cv DB_USER=mon_cv DB_PASSWORD=mon_cv_local_test php -S 127.0.0.1:8001 -t backend/public backend/public/index.php
```

```sh
php -S 127.0.0.1:8000 -t frontend
```

Ouvrir <http://127.0.0.1:8000>. L'API répond sur <http://127.0.0.1:8001/api/cv> ; <http://127.0.0.1:8001/api/health> permet de vérifier le serveur. Le navigateur charge les données du CV depuis l'API. Si l'API ne répond pas, le frontend garde son contenu de secours.

La configuration locale du frontend est dans `frontend/config.js`. Si son adresse change, adapter également `FRONTEND_ORIGIN` au démarrage du backend pour autoriser cet origin dans le navigateur. Le backend peut tourner sans MySQL : il retourne alors les données de démonstration du modèle.

## Organisation

- `backend/public/index.php` : point d'entrée HTTP et routage.
- `backend/src/Model/CvModel.php` : lecture des données du CV, avec valeurs de secours.
- `backend/src/Controller/CvController.php` : réponse JSON de l'API.
- `backend/src/Infrastructure/Database.php` : connexion PDO facultative à MySQL.
- `backend/bin/setup.php` : création des tables et données de démonstration depuis le terminal, sans effacement.
- `frontend/index.php`, `frontend/pages/` et `frontend/navigation.php` : affichage du site.
- `frontend/js/app.js` : lecture de l'API et mise à jour du CV.
- `frontend/css/`, `frontend/tailwind.config.js` et `frontend/output.css` : sources et sortie CSS.

## Modifier les styles

```sh
cd frontend
npm ci
npm run build:css
```

`frontend/output.css` est versionné : Node.js n'est pas nécessaire pour afficher le site. `npm run dev:css` reconstruit le CSS à chaque modification.

## Base de test

MySQL n'est exposé que sur `127.0.0.1:3307`. Les identifiants du Compose sont **uniquement pour le développement local** ; ne pas les utiliser en production. `docker compose down` arrête la base en conservant les données. `docker compose down -v` efface le volume de test.

GitHub Pages ne lance pas PHP : pour publier cette version dynamique, il faut un hébergement PHP pour le backend et le frontend. L'authentification, l'envoi de messages et l'upload de photo restent des exercices futurs ; aucune route publique ne les active.
