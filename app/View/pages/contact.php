<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Portfolio</title>
    <!-- Police Poppins & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/output.css">
</head>
<body class="bg-slate-200 font-['Poppins'] min-h-screen py-8 px-4 sm:px-6 lg:px-8 antialiased">

    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Inclusion du composant de navigation modulaire -->
        <?php require dirname(__DIR__) . '/partials/navigation.php'; ?>

        <!-- Carte Principale Contact -->
        <div class="bg-white rounded-2xl shadow-xl p-8 space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-navy-900 flex items-center space-x-3">
                    <i class="fa-solid fa-envelope text-sky-500"></i>
                    <span>Contactez-moi</span>
                </h1>
                <p class="text-xs text-slate-500 mt-2">
                    N'hésitez pas à m'envoyer un message pour toute opportunité de stage, projet ou collaboration en Génie Informatique.
                </p>
            </div>

            <hr class="border-slate-200">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Coordonnées rapides -->
                <div class="space-y-4 text-xs text-slate-600">
                    <div class="flex items-center space-x-3 bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <i class="fa-solid fa-phone text-sky-600 text-sm w-5 text-center"></i>
                        <span>+224 624 18 55 47</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <i class="fa-solid fa-envelope text-sky-600 text-sm w-5 text-center"></i>
                        <span>mamadousiradjob49@gmail.com</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <i class="fa-solid fa-location-dot text-sky-600 text-sm w-5 text-center"></i>
                        <span>Conakry, Guinée</span>
                    </div>
                </div>

                <!-- Contact direct : aucun traitement de formulaire n'est encore disponible. -->
                <div class="md:col-span-2 flex items-center">
                    <a href="mailto:mamadousiradjob49@gmail.com" class="bg-navy-900 hover:bg-navy-800 text-white font-semibold text-xs px-5 py-2.5 rounded-lg shadow transition">
                        Écrire un e-mail
                    </a>
                </div>
            </div>
        </div>

    </div>

</body>
</html>