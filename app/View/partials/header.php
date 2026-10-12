<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle ?? 'Mini-bibliothèque', ENT_QUOTES, 'UTF-8') ?> — Mini-bibliothèque</title>
    <link rel="stylesheet" href="/output.css">
</head>
<body class="flex min-h-screen flex-col bg-slate-100 text-slate-900">
    <header class="border-b border-slate-200 bg-white">
        <nav class="mx-auto flex max-w-3xl items-center px-4 py-4" aria-label="Navigation principale">
            <a href="/" class="font-bold text-indigo-700 hover:text-indigo-900">Mini-bibliothèque</a>
        </nav>
    </header>
    <main class="mx-auto w-full max-w-3xl flex-1 px-4 py-10">
