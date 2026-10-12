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

L'accueil utilise la photo de `images/` sans MySQL. Pour expérimenter avec MySQL, créer d'abord une base vide et définir les variables d'environnement `DB_NAME`, `DB_USER`, `DB_PASSWORD`, et éventuellement `DB_HOST` et `DB_PORT`. Exécuter ensuite depuis le terminal :

```sh
php backend/setup.php
```

Ce script crée les tables sans effacer les données existantes. Il ne peut pas être exécuté depuis le navigateur. Ne pas placer les identifiants de la base dans un fichier suivi par Git.

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
