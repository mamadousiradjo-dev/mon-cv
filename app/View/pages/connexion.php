<?php use App\Infrastructure\View; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion — Mon CV</title>
    <link rel="stylesheet" href="/output.css">
</head>
<body class="bg-slate-200 font-sans min-h-screen p-4 sm:p-8">
    <div class="max-w-3xl mx-auto space-y-6">
        <?php require dirname(__DIR__) . '/partials/navigation.php'; ?>

        <main class="bg-white rounded-2xl shadow-xl p-8">
            <h1 class="text-2xl font-bold text-navy-900 mb-6">Connexion</h1>
            <?php if ($flash !== null): ?>
                <p role="alert" class="text-sm text-red-700 mb-4"><?= View::e($flash) ?></p>
            <?php endif; ?>

            <form action="/connexion" method="post" class="space-y-4 max-w-md">
                <input type="hidden" name="csrf" value="<?= View::e($csrf) ?>">
                <label class="block">
                    E-mail
                    <input name="email" type="email" autocomplete="email" required class="mt-1 block w-full border rounded-lg p-2">
                </label>
                <label class="block">
                    Mot de passe
                    <input name="password" type="password" autocomplete="current-password" required class="mt-1 block w-full border rounded-lg p-2">
                </label>
                <button type="submit" class="bg-navy-900 text-white rounded-lg px-4 py-2">Se connecter</button>
            </form>

            <p class="mt-5 text-sm">
                Pas de compte ? <a href="/inscription" class="text-sky-700 underline">S’inscrire</a>
            </p>
        </main>
    </div>
</body>
</html>
