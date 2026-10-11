<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Portfolio</title>
    <!-- Police Poppins & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Tailwind CSS avec configuration de la couleur Navy -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            900: '#0F2C59',
                            800: '#183B70',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-200 font-['Poppins'] min-h-screen py-8 px-4 sm:px-6 lg:px-8 antialiased">

    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Inclusion du composant de navigation modulaire -->
        <?php include __DIR__ . '/../navigation.php'; ?>

        <!-- Carte Principale Inscription -->
        <div class="bg-white rounded-2xl shadow-xl p-8 space-y-6 max-w-lg mx-auto">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-navy-900 flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-user-plus text-sky-500"></i>
                    <span>Inscription</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Créez votre compte pour accéder à l'espace d'administration du portfolio.
                </p>
            </div>

            <hr class="border-slate-200">

            <!-- Formulaire d'inscription -->
            <form action="#" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nom d'utilisateur</label>
                    <input type="text" name="username" required class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Adresse E-mail</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Mot de passe</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <button type="submit" class="w-full bg-navy-900 hover:bg-navy-800 text-white font-semibold text-xs py-2.5 rounded-lg shadow transition flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-user-check"></i>
                    <span>S'inscrire</span>
                </button>
            </form>

            <div class="text-center text-xs text-slate-500">
                Déjà un compte ? <a href="connexion.php" class="text-sky-600 font-semibold hover:underline">Se connecter</a>
            </div>
        </div>

    </div>

</body>
</html>