<?php
// Connexion à la base de données
require_once 'backend/db.php';

try {
    // Récupération des expériences
    $stmtExp = $pdo->query("SELECT * FROM experiences ORDER BY id DESC");
    $experiences = $stmtExp->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des formations / diplômes
    $stmtForm = $pdo->query("SELECT * FROM formations ORDER BY id DESC");
    $formations = $stmtForm->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur d'accès à la base de données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-900 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon CV Dynamique</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen py-10 px-4 sm:px-6 lg:px-8">

    <div class="max-w-4xl mx-auto space-y-8">
        
        <!-- En-tête / Profil -->
        <header class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-xl flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white">Mon Portfolio CV</h1>
                <p class="text-indigo-400 font-medium mt-1">Développeur Web & Base de Données</p>
            </div>
            <div class="flex gap-3">
                <a href="pages/connexion.html" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-medium transition">Connexion</a>
                <a href="pages/inscription.html" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition">Inscription</a>
            </div>
        </header>

        <!-- Section Expériences (Dynamique via MySQL) -->
        <section class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-xl space-y-4">
            <h2 class="text-2xl font-bold text-white border-b border-slate-700 pb-2 flex items-center gap-2">
                💼 Expériences Professionnelles
            </h2>
            
            <div class="space-y-4 mt-4">
                <?php if (!empty($experiences)): ?>
                    <?php foreach ($experiences as $exp): ?>
                        <div class="p-4 bg-slate-900 rounded-lg border border-slate-700">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-bold text-indigo-400"><?= htmlspecialchars($exp['titre']) ?></h3>
                                <span class="text-xs bg-slate-800 text-slate-300 px-2.5 py-1 rounded-full border border-slate-700"><?= htmlspecialchars($exp['periode']) ?></span>
                            </div>
                            <p class="text-sm text-slate-400 font-medium mt-1"><?= htmlspecialchars($exp['entreprise']) ?></p>
                            <p class="text-slate-300 mt-2 text-sm"><?= htmlspecialchars($exp['description']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-slate-400">Aucune expérience enregistrée.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Section Formations & Diplômes (Dynamique via MySQL) -->
        <section class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-xl space-y-4">
            <h2 class="text-2xl font-bold text-white border-b border-slate-700 pb-2 flex items-center gap-2">
                🎓 Formations & Diplômes
            </h2>

            <div class="space-y-4 mt-4">
                <?php if (!empty($formations)): ?>
                    <?php foreach ($formations as $form): ?>
                        <div class="p-4 bg-slate-900 rounded-lg border border-slate-700 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold text-white"><?= htmlspecialchars($form['diplome']) ?></h3>
                                <p class="text-sm text-slate-400"><?= htmlspecialchars($form['etablissement']) ?></p>
                            </div>
                            <span class="text-xs bg-indigo-900/50 text-indigo-300 px-3 py-1 rounded-full border border-indigo-700"><?= htmlspecialchars($form['annee']) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-slate-400">Aucune formation enregistrée.</p>
                <?php endif; ?>
            </div>
        </section>

    </div>

</body>
</html>