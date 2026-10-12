<?php use App\View\View; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erreur <?= View::e($status) ?> — Mon CV</title>
    <link rel="stylesheet" href="/output.css">
</head>
<body class="bg-slate-200 font-sans min-h-screen p-4 sm:p-8">
    <main class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-2xl font-bold text-navy-900 mb-4">Erreur <?= View::e($status) ?></h1>
        <p class="text-slate-600 mb-5"><?= View::e($message) ?></p>
        <a href="/" class="text-sky-700 underline">Retour à l’accueil</a>
    </main>
</body>
</html>
