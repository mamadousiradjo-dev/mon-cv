<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription — Mon CV</title>
    <link rel="stylesheet" href="/output.css">
</head>
<body class="bg-slate-200 font-sans min-h-screen p-4 sm:p-8">
    <div class="max-w-3xl mx-auto space-y-6">
        <?php include dirname(__DIR__) . '/navigation.php'; ?>

        <main class="bg-white rounded-2xl shadow-xl p-8">
            <h1 class="text-2xl font-bold text-navy-900 mb-6">Inscription</h1>

            <form id="account-form" data-mode="register" class="space-y-4 max-w-md">
                <label class="block">
                    Nom
                    <input
                        name="name"
                        type="text"
                        minlength="2"
                        maxlength="80"
                        autocomplete="name"
                        required
                        class="mt-1 block w-full border rounded-lg p-2"
                    >
                </label>

                <label class="block">
                    E-mail
                    <input
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        class="mt-1 block w-full border rounded-lg p-2"
                    >
                </label>

                <label class="block">
                    Mot de passe (12 caractères minimum)
                    <input
                        name="password"
                        type="password"
                        minlength="12"
                        autocomplete="new-password"
                        required
                        class="mt-1 block w-full border rounded-lg p-2"
                    >
                </label>

                <label class="block">
                    Confirmer le mot de passe
                    <input
                        name="confirmation"
                        type="password"
                        minlength="12"
                        autocomplete="new-password"
                        required
                        class="mt-1 block w-full border rounded-lg p-2"
                    >
                </label>

                <button type="submit" class="bg-navy-900 text-white rounded-lg px-4 py-2">
                    Créer mon compte
                </button>
                <p id="account-message" role="status" aria-live="polite" class="text-sm text-red-700"></p>
            </form>
        </main>
    </div>

    <script src="/config.js"></script>
    <script src="/js/auth.js" defer></script>
    <script src="/js/account.js" defer></script>
</body>
</html>
