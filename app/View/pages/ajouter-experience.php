<?php use App\View\View; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter une expérience — Mon CV</title>
    <link rel="stylesheet" href="/output.css">
</head>
<body class="bg-slate-200 font-sans min-h-screen p-4 sm:p-8">
    <div class="max-w-3xl mx-auto space-y-6">
        <?php require dirname(__DIR__) . '/partials/navigation.php'; ?>
        <main class="bg-white rounded-2xl shadow-xl p-8">
            <h1 class="text-2xl font-bold text-navy-900 mb-6">Ajouter une expérience</h1>
            <?php if ($flash !== null): ?>
                <p role="alert"><?= View::e($flash) ?></p>
            <?php endif; ?>
            <form action="/experiences" method="post" class="space-y-4 max-w-md">
                <input type="hidden" name="csrf" value="<?= View::e($csrf) ?>">
                <label class="block">Titre
                    <input name="title" required maxlength="255" class="mt-1 block w-full border rounded-lg p-2">
                </label>
                <label class="block">Entreprise
                    <input name="company" required maxlength="255" class="mt-1 block w-full border rounded-lg p-2">
                </label>
                <label class="block">Période
                    <input name="period" required maxlength="100" placeholder="Ex. : 2025–2026" class="mt-1 block w-full border rounded-lg p-2">
                </label>
                <label class="block">Description
                    <textarea name="description" rows="4" class="mt-1 block w-full border rounded-lg p-2"></textarea>
                </label>
                <button type="submit" class="bg-navy-900 text-white rounded-lg px-4 py-2">Enregistrer</button>
            </form>
        </main>
    </div>
</body>
</html>
