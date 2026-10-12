<?php
$pageTitle = 'Livres';
require __DIR__ . '/partials/header.php';
?>
<section>
    <div class="mb-8">
        <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-indigo-600">Exercice MVC</p>
        <h1 class="text-3xl font-bold">Les livres</h1>
        <p class="mt-2 text-slate-600">Voici les livres disponibles dans la base.</p>
    </div>

    <ul class="space-y-3">
        <?php foreach ($books as $book): ?>
            <li class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold"><?= htmlspecialchars($book->title, ENT_QUOTES, 'UTF-8') ?></h2>
                        <p class="text-sm text-slate-600"><?= htmlspecialchars($book->author, ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <?php if ($book->borrowed): ?>
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-medium text-amber-900">Emprunté</span>
                    <?php else: ?>
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-medium text-emerald-900">Disponible</span>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <!-- TODO élève : ajouter les liens et formulaires des nouvelles fonctionnalités. -->
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
