<?php
// Connexion à la base de données
require_once 'backend/db.php';

try {
    // Récupération des expériences depuis MySQL
    $stmtExp = $pdo->query("SELECT * FROM experiences ORDER BY id DESC");
    $experiences = $stmtExp->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des formations depuis MySQL
    $stmtForm = $pdo->query("SELECT * FROM formations ORDER BY id DESC");
    $formations = $stmtForm->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur d'accès à la base de données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr" class="bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mamadou Siradjo Balde - Portfolio & CV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Importation de la police Poppins depuis Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            800: '#1e3a5f',
                            900: '#132e4f',
                            950: '#0f233d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-200 min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-sans antialiased text-slate-800">

    <div class="max-w-5xl mx-auto space-y-6">
        
        <!-- Barre de Navigation Bleu Marine -->
        <nav class="bg-navy-900 text-white rounded-xl shadow-lg p-4 flex justify-center items-center space-x-8 text-sm font-medium tracking-wide">
            <a href="index.php" class="px-4 py-2 bg-white text-navy-900 rounded-lg font-bold shadow-sm transition">Accueil</a>
            <a href="pages/projets.html" class="hover:text-sky-300 transition">Projets</a>
            <a href="pages/contact.html" class="hover:text-sky-300 transition">Contact</a>
            <a href="pages/connexion.html" class="hover:text-sky-300 transition">Connexion</a>
            <a href="pages/inscription.html" class="hover:text-sky-300 transition">Inscription</a>
        </nav>

        <!-- Contenu Principal sur 2 colonnes -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row min-h-[780px]">
            
            <!-- Colonne de Gauche : Bleu Marine -->
            <aside class="w-full md:w-2/5 bg-navy-900 text-white p-8 flex flex-col items-center text-center space-y-6">
                
                <!-- Photo de Profil -->
                <div class="pt-2">
                    <img src="images/MAMADOU SIRADJO BALDE.jpeg" alt="Mamadou Siradjo Balde" class="w-36 h-36 rounded-full border-4 border-white/90 object-cover shadow-xl mx-auto">
                </div>

                <!-- Identité (Sans accent sur BALDE) -->
                <div>
                    <h1 class="text-xl font-bold uppercase tracking-wider leading-snug">Mamadou Siradjo</h1>
                    <h1 class="text-xl font-bold uppercase tracking-wider leading-snug">Balde</h1>
                    <p class="text-xs text-sky-300 uppercase font-semibold mt-3 tracking-widest bg-navy-950/50 py-1.5 px-3 rounded-md border border-sky-800/40">Etudiant en Génie Informatique</p>
                </div>

                <!-- Contact -->
                <div class="w-full text-left border-t border-sky-800/60 pt-5 space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-sky-300">Contact</h3>
                    <ul class="text-xs space-y-2.5 text-slate-200 font-normal">
                        <li class="flex items-center gap-3"><i class="fas fa-phone w-4 text-sky-400 text-center"></i> +224 624 18 55 47</li>
                        <li class="flex items-center gap-3"><i class="fas fa-envelope w-4 text-sky-400 text-center"></i> mamadousiradjob49@gmail.com</li>
                        <li class="flex items-center gap-3"><i class="fas fa-map-marker-alt w-4 text-sky-400 text-center"></i> Conakry, Guinée</li>
                    </ul>
                </div>

                <!-- Compétences -->
                <div class="w-full text-left border-t border-sky-800/60 pt-5 space-y-2.5">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-sky-300">Compétences</h3>
                    <ul class="text-xs space-y-2 text-slate-200 font-normal list-disc list-inside">
                        <li>HTML5 / CSS3 / Tailwind CSS</li>
                        <li>PHP / MySQL (PDO)</li>
                        <li>Git & GitHub</li>
                        <li>Bases de données & Systèmes</li>
                    </ul>
                </div>

                <!-- Langues -->
                <div class="w-full text-left border-t border-sky-800/60 pt-5 space-y-2">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-sky-300">Langues</h3>
                    <p class="text-xs text-slate-200 font-normal">Français (Courant)</p>
                </div>

            </aside>

            <!-- Colonne de Droite : Fond Blanc -->
            <main class="w-full md:w-3/5 p-10 space-y-8 bg-white">
                
                <!-- Section Profil -->
                <section>
                    <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider border-b-2 border-navy-900 pb-2 mb-3">Profil</h2>
                    <p class="text-xs text-slate-600 leading-relaxed font-normal">
                        Etudiant en génie informatique, motivé et passionné par les technologies numériques. Je développe progressivement mes compétences en programmation, développement web, bases de données et outils informatiques.
                    </p>
                </section>

                <!-- Section Formation -->
                <section>
                    <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider border-b-2 border-navy-900 pb-2 mb-3">Formation</h2>
                    <div class="space-y-4">
                        <?php if (!empty($formations)): ?>
                            <?php foreach ($formations as $form): ?>
                                <div>
                                    <h3 class="text-sm font-semibold text-navy-900"><?= htmlspecialchars($form['diplome']) ?></h3>
                                    <p class="text-xs text-slate-500 font-normal mt-0.5"><?= htmlspecialchars($form['etablissement']) ?> <span class="text-slate-400">• <?= htmlspecialchars($form['annee']) ?></span></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div>
                                <h3 class="text-sm font-semibold text-navy-900">Brevet Technique 3 (BT3) - Génie Informatique</h3>
                                <p class="text-xs text-slate-500 font-normal mt-0.5">Université Mahatma Gandhi • En cours (3ème année)</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Section Experience -->
                <section>
                    <h2 class="text-sm font-bold text-navy-900 uppercase tracking-wider border-b-2 border-navy-900 pb-2 mb-3">Experience</h2>
                    <div class="space-y-5">
                        <?php if (!empty($experiences)): ?>
                            <?php foreach ($experiences as $exp): ?>
                                <div>
                                    <div class="flex justify-between items-baseline">
                                        <h3 class="text-sm font-semibold text-navy-900"><?= htmlspecialchars($exp['titre']) ?></h3>
                                        <span class="text-xs font-medium text-slate-400 bg-slate-100 px-2.5 py-0.5 rounded"><?= htmlspecialchars($exp['periode']) ?></span>
                                    </div>
                                    <p class="text-xs text-sky-700 font-medium mt-0.5"><?= htmlspecialchars($exp['entreprise']) ?></p>
                                    <p class="text-xs text-slate-600 leading-relaxed mt-1.5 font-normal"><?= htmlspecialchars($exp['description']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div>
                                <h3 class="text-sm font-semibold text-navy-900">Projet Web : Portfolio CV Dynamique</h3>
                                <p class="text-xs text-sky-700 font-medium mt-0.5">Projet Académique / Personnel</p>
                                <p class="text-xs text-slate-600 leading-relaxed mt-1.5 font-normal">Conception et développement d'un site CV dynamique avec PHP, MySQL (PDO), Tailwind CSS et gestion de base de données.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

            </main>

        </div>

    </div>

</body>
</html>