<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mamadou Siradjo Balde - Portfolio</title>
    <!-- Police Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome pour de vraies icônes professionnelles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/output.css">
</head>
<body class="bg-slate-200 font-['Poppins'] min-h-screen py-8 px-4 sm:px-6 lg:px-8 antialiased">

    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Composant de navigation modulaire -->
        <?php include __DIR__ . '/navigation.php'; ?>

        <!-- Carte principale CV / Portfolio -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">
            
            <!-- Colonne Gauche : Carte d'identité / Profil -->
            <div class="bg-navy-900 text-white md:w-1/3 p-8 flex flex-col items-center text-center space-y-6">
                
                <!-- Photo du CV -->
                <div class="relative">
                    <img id="profile-img" src="images/MAMADOU SIRADJO BALDE.jpeg" alt="Portrait de Mamadou Siradjo Baldé" class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-md">
                </div>

                <!-- Informations Personnelles -->
                <div>
                    <h1 class="text-xl font-bold tracking-wider">MAMADOU SIRADJO BALDE</h1>
                    <p class="text-xs text-sky-300 font-semibold tracking-widest mt-1 uppercase">ETUDIANT EN GENIE INFORMATIQUE</p>
                </div>

                <hr class="w-full border-slate-700">

                <!-- Coordonnées avec VRAIES ICÔNES -->
                <div class="w-full text-left space-y-3 text-xs text-slate-300">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-phone text-sky-400 w-4 text-center"></i>
                        <span>+224 624 18 55 47</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-envelope text-sky-400 w-4 text-center"></i>
                        <span>mamadousiradjob49@gmail.com</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-location-dot text-sky-400 w-4 text-center"></i>
                        <span>Conakry, Guinée</span>
                    </div>
                </div>

                <hr class="w-full border-slate-700">

                <!-- Compétences avec Icônes -->
                <div class="w-full text-left space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 flex items-center space-x-2">
                        <i class="fa-solid fa-code"></i>
                        <span>COMPETENCES</span>
                    </h3>
                    <ul class="text-xs space-y-2 text-slate-300">
                        <li class="flex items-center space-x-2">
                            <i class="fa-brands fa-html5 text-orange-400"></i>
                            <span>HTML5 / CSS3 / Tailwind CSS</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fa-brands fa-php text-indigo-300"></i>
                            <span>PHP / MySQL (PDO)</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fa-brands fa-git-alt text-orange-500"></i>
                            <span>Git & GitHub</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fa-solid fa-database text-sky-300"></i>
                            <span>Bases de données & Systèmes</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Colonne Droite : Contenu du CV -->
            <div class="md:w-2/3 p-8 space-y-8">
                
                <!-- Section Profil -->
                <section>
                    <h2 class="text-lg font-bold text-navy-900 border-b-2 border-navy-900 pb-1 mb-3 uppercase flex items-center space-x-2">
                        <i class="fa-solid fa-user-gear text-navy-900 text-sm"></i>
                        <span>PROFIL</span>
                    </h2>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Etudiant motivé et passionné par les technologies numériques. Je développe mes compétences en programmation, développement web, bases de données et outils informatiques.
                    </p>
                </section>

                <!-- Section Formation -->
                <section>
                    <h2 class="text-lg font-bold text-navy-900 border-b-2 border-navy-900 pb-1 mb-3 uppercase flex items-center space-x-2">
                        <i class="fa-solid fa-graduation-cap text-navy-900 text-sm"></i>
                        <span>FORMATION</span>
                    </h2>
                    <div class="space-y-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 id="formation-diplome" class="text-sm font-semibold text-navy-900">Brevet Technique 3 (BT3) - Génie Informatique</h3>
                                <p class="text-xs text-slate-500 mt-0.5 flex items-center space-x-1">
                                    <i class="fa-solid fa-building-columns text-slate-400 text-xs mr-1"></i>
                                    <span id="formation-detail">Université Mahatma Gandhi • En cours (3ème année)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section Expérience / Projets -->
                <section>
                    <h2 class="text-lg font-bold text-navy-900 border-b-2 border-navy-900 pb-1 mb-3 uppercase flex items-center space-x-2">
                        <i class="fa-solid fa-briefcase text-navy-900 text-sm"></i>
                        <span>EXPERIENCE</span>
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center">
                                <h3 id="experience-titre" class="text-sm font-semibold text-navy-900">Projet Web : Portfolio CV Dynamique</h3>
                                <span id="experience-periode" class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded">2026</span>
                            </div>
                            <p id="experience-entreprise" class="text-xs text-sky-600 font-medium mt-0.5">Projet Académique / Personnel</p>
                            <p id="experience-description" class="text-xs text-slate-600 mt-1">
                                Conception et développement d'un site CV dynamique avec PHP, MySQL (PDO), Tailwind CSS ; l'espace d'administration reste à développer.
                            </p>
                        </div>
                    </div>
                </section>

            </div>

        </div>

    </div>

    <script src="/config.js"></script>
    <script src="/js/app.js" defer></script>
</body>
</html>
