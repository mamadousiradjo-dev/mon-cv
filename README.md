# CV de Mamadou Siradjo Baldé

Site CV en PHP et Tailwind CSS. Les pages publiques sont l'accueil, les projets et le contact.

## Lancer le site

Prérequis : PHP 8.0+ et Node.js/npm pour reconstruire la feuille de style.

```sh
git clone -b tailwind-simple https://github.com/mamadousiradjo-dev/mon-cv.git
cd mon-cv
npm ci
npm run build:css
php -S 127.0.0.1:8000
```

Ouvrir <http://127.0.0.1:8000>. Le fichier `output.css` est versionné, donc PHP seul suffit pour une première visite. Après une modification des classes Tailwind, relancer `npm run build:css`. Pour compiler à chaque changement : `npm run dev:css`.

## Base de données facultative

L'accueil utilise la photo de `images/` sans MySQL. Le fichier `compose.yaml` lance une base **uniquement pour les tests locaux**. Il utilise des identifiants de démonstration et expose MySQL seulement sur `127.0.0.1:3307`.

```sh
docker compose up -d --wait db
DB_HOST=127.0.0.1 DB_PORT=3307 DB_NAME=mon_cv DB_USER=mon_cv DB_PASSWORD=mon_cv_local_test php backend/setup.php
DB_HOST=127.0.0.1 DB_PORT=3307 DB_NAME=mon_cv DB_USER=mon_cv DB_PASSWORD=mon_cv_local_test php -S 127.0.0.1:8000
```

La première commande télécharge et démarre MySQL si nécessaire, puis attend que la base soit prête. Ce script crée les tables sans effacer les données existantes et ne peut pas être exécuté depuis le navigateur. Pour arrêter la base : `docker compose down`. Pour repartir d'une base vide **en effaçant les données de test** : `docker compose down -v`.

Pour une autre base MySQL, définir `DB_NAME`, `DB_USER`, `DB_PASSWORD`, et éventuellement `DB_HOST` et `DB_PORT` dans l'environnement. Ne pas copier les identifiants de démonstration en production ni suivre de vrais secrets dans Git.

## Organisation

- `index.php` : page d'accueil et lecture facultative du chemin de la photo depuis MySQL.
- `navigation.php` : menu partagé entre les pages.
- `pages/` : projets et contact.
- `backend/db.php` : connexion PDO facultative.
- `backend/setup.php` : création des tables depuis le terminal.
- `css/projets.css`, `tailwind.config.js` et `output.css` : sources et sortie Tailwind.

## Prochaines étapes pédagogiques

L'inscription, la connexion, l'envoi de message et le changement de photo ne sont pas encore implémentés. L'upload public est désactivé pour éviter qu'un visiteur modifie le CV. Pour ajouter un espace d'administration, commencer par les sessions PHP, le hachage des mots de passe, les requêtes préparées, la protection CSRF et la vérification du type réel des images avant de réactiver l'upload.

GitHub Pages ne lance pas PHP. Héberger ce projet sur un serveur PHP pour publier la version dynamique.
