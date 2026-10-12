# CV de Mamadou Siradjo Baldé

Le dépôt contient deux projets séparés :

- **`backend/`** : API PHP en architecture **MC** (Modèle + Contrôleur), sans vues HTML.
- **`frontend/`** : pages du CV, images, JavaScript et Tailwind CSS. C'est le projet de vue distinct.

La base MySQL de test se lance avec `compose.yaml` à la racine. Le site reste lisible si le backend ou MySQL est arrêté.

## Démarrage local

Prérequis : PHP 8.1+ avec PDO MySQL et fileinfo, Docker Compose et, pour modifier les styles, Node.js/npm.

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

## Comptes et droits

- `/pages/inscription.php` crée un compte standard avec mot de passe haché.
- `/pages/connexion.php` ouvre une session PHP ; le bouton « Déconnexion » la ferme.
- Le propriétaire crée d'abord son compte par inscription, puis le promeut **localement** depuis le terminal :

```sh
DB_HOST=127.0.0.1 DB_PORT=3307 DB_NAME=mon_cv DB_USER=mon_cv DB_PASSWORD=mon_cv_local_test php backend/bin/promote_admin.php son-adresse@example.com
```

Après cette commande, recharger la page. Seul ce compte peut ouvrir « Utilisateurs » et modifier la photo du CV. Aucun rôle propriétaire ne peut être demandé depuis le navigateur. La page des utilisateurs ne reçoit jamais les mots de passe hachés.

Routes API : `GET /api/session`, `POST /api/register`, `POST /api/login`, `POST /api/logout`, `GET /api/users` et `POST /api/photo`. Les appels `POST` exigent le jeton CSRF renvoyé par `/api/session` dans l'en-tête `X-CSRF-Token`. L'upload accepte JPG, PNG ou WebP de 5 Mo maximum et stocke les fichiers hors du répertoire public. Les chemins générés sont servis par `GET /api/photos/{nom}`.

## Organisation

- `backend/public/index.php` : point d'entrée HTTP et routage.
- `backend/src/Model/CvModel.php` : lecture des données du CV, avec valeurs de secours.
- `backend/src/Controller/` : réponses JSON pour le CV, les comptes et la photo.
- `backend/src/Model/UserModel.php` : accès aux comptes avec requêtes préparées.
- `backend/src/Infrastructure/Database.php` : connexion PDO facultative à MySQL.
- `backend/bin/setup.php` : création des tables et données de démonstration depuis le terminal, sans effacement.
- `backend/bin/promote_admin.php` : promotion manuelle du propriétaire.
- `backend/storage/uploads/` : photos locales non versionnées.
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

GitHub Pages ne lance pas PHP : pour publier cette version dynamique, il faut un hébergement PHP pour le backend et le frontend. L'envoi de messages reste un exercice futur. Avant une mise en production, configurer HTTPS, des identifiants MySQL distincts et une limitation des tentatives de connexion.
