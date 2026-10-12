<?php use App\Infrastructure\View; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utilisateurs — Mon CV</title>
    <link rel="stylesheet" href="/output.css">
</head>
<body class="bg-slate-200 font-sans min-h-screen p-4 sm:p-8">
    <div class="max-w-3xl mx-auto space-y-6">
        <?php require dirname(__DIR__) . '/partials/navigation.php'; ?>

        <main class="bg-white rounded-2xl shadow-xl p-8">
            <h1 class="text-2xl font-bold text-navy-900 mb-4">Utilisateurs inscrits</h1>
            <p class="text-sm text-slate-600 mb-4"><?= count($users) ?> compte(s) inscrit(s).</p>

            <ul class="space-y-3">
                <?php foreach ($users as $account): ?>
                    <li class="rounded-lg border border-slate-200 p-3">
                        <?= View::e($account['nom']) ?> — <?= View::e($account['email']) ?>
                        (<?= $account['role'] === 'admin' ? 'propriétaire' : 'utilisateur' ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        </main>
    </div>
</body>
</html>
