<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Portfolio CV</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center p-4">

    <div class="w-full max-w-md p-8 space-y-6 bg-slate-800 rounded-xl shadow-2xl border border-slate-700">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-white">Créer un compte</h2>
            <p class="mt-2 text-sm text-slate-400">Inscrivez-vous pour accéder à votre espace</p>
        </div>

        <form action="../backend/inscription.php" method="POST" class="space-y-5">
            <div>
                <label for="nom" class="block text-sm font-medium text-slate-300">Nom complet</label>
                <input type="text" id="nom" name="nom" required placeholder="Mamadou Balde" 
                    class="mt-1 block w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-300">Adresse Email</label>
                <input type="email" id="email" name="email" required placeholder="nom@exemple.com" 
                    class="mt-1 block w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            </div>

            <div>
                <label for="mot_de_passe" class="block text-sm font-medium text-slate-300">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required placeholder="••••••••" 
                    class="mt-1 block w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            </div>

            <button type="submit" 
                class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-slate-800 transition">
                S'inscrire
            </button>
        </form>

        <p class="text-center text-sm text-slate-400">
            Déjà un compte ? 
            <a href="connexion.html" class="font-medium text-indigo-400 hover:text-indigo-300 hover:underline">Se connecter</a>
        </p>
    </div>

</body>
</html>