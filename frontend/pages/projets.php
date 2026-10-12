<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets - Portfolio</title>
    <!-- Police Poppins & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/output.css">
</head>
<body class="bg-slate-200 font-['Poppins'] min-h-screen py-8 px-4 sm:px-6 lg:px-8 antialiased">

    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Inclusion du composant de navigation modulaire -->
        <?php include __DIR__ . '/../navigation.php'; ?>

        <!-- Carte Principale Projets -->
        <div class="bg-white rounded-2xl shadow-xl p-8 space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-navy-900 flex items-center space-x-3">
                    <i class="fa-solid fa-diagram-project text-sky-500"></i>
                    <span>Mes Projets Académiques & Personnels</span>
                </h1>
                <p class="text-xs text-slate-500 mt-2">
                    Découvrez ici les différents projets réalisés au cours de mon cursus en Génie Informatique à l'Université Mahatma Gandhi.
                </p>
            </div>

            <hr class="border-slate-200">

            <!-- Liste des projets sous forme de cartes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Projet 1 : Portfolio CV Dynamique -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs font-bold text-sky-600 bg-sky-100 px-2.5 py-1 rounded-full uppercase">PHP / MySQL</span>
                        <span class="text-xs text-slate-400 font-semibold">2026</span>
                    </div>
                    <h3 class="text-base font-bold text-navy-900 mb-2">Application Web Portfolio CV</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Développement d'une plateforme web modulaire avec pages PHP, styles Tailwind et connexion MySQL facultative. L'espace d'administration reste à développer.
                    </p>
                    <div class="flex items-center space-x-2 text-xs text-slate-500 font-medium">
                        <i class="fa-brands fa-github text-slate-700"></i>
                        <span>Repo : mamadousiradjo-dev/mon-cv</span>
                    </div>
                </div>

                <!-- Projet 2 : Gestion de Base de Données -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs font-bold text-indigo-600 bg-indigo-100 px-2.5 py-1 rounded-full uppercase">SQL & Modélisation</span>
                        <span class="text-xs text-slate-400 font-semibold">2026</span>
                    </div>
                    <h3 class="text-base font-bold text-navy-900 mb-2">Conception BDD Relationnelle</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Modélisation de schémas de données relationnels (MCD/MLD) et rédaction de requêtes SQL complexes pour l'optimisation des requêtes applicatives.
                    </p>
                    <div class="flex items-center space-x-2 text-xs text-slate-500 font-medium">
                        <i class="fa-solid fa-database text-slate-700"></i>
                        <span>Projet Académique BT3</span>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script src="/config.js"></script>
    <script src="/js/auth.js" defer></script>
</body>
</html>