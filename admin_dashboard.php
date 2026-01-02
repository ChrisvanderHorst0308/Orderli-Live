<?php
session_start();

$USERNAME = 'chris';
$PASSWORD = 'Orderli123';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: /admin_login.php');
    exit;
}

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: /admin_login.php');
    exit;
}

$promptsFile = __DIR__ . '/prompts.json';
if (!file_exists($promptsFile)) {
    file_put_contents($promptsFile, json_encode([]));
}

$prompts = json_decode(file_get_contents($promptsFile), true) ?? [];

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    if ($title && $content) {
        $prompts[] = [
            'title' => $title,
            'content' => $content,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        file_put_contents($promptsFile, json_encode($prompts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $message = 'Prompt opgeslagen';
    } else {
        $message = 'Titel en inhoud zijn verplicht';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-50 min-h-screen">
    <header class="border-b border-slate-800 bg-slate-900/70 backdrop-blur sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center font-bold">A</div>
                <div>
                    <p class="text-xs text-slate-400">Orderli Admin</p>
                    <h1 class="text-xl font-semibold">Dashboard</h1>
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm text-slate-400">
                <a href="http://localhost:8000" class="hover:text-white">Generator</a>
                <span class="text-slate-600">|</span>
                <a href="http://localhost:8001" class="hover:text-white">Viewer</a>
                <span class="text-slate-600">|</span>
                <a href="?action=logout" class="text-red-300 hover:text-red-200">Uitloggen</a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8 space-y-8">
        <section class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-blue-900/20">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-400">Promptbeheer</p>
                    <h2 class="text-2xl font-semibold text-slate-50">Nieuwe prompt</h2>
                    <p class="text-sm text-slate-400 mt-1">Maak prompts aan om later te gebruiken</p>
                </div>
                <div class="text-xs text-slate-500">Ingelogd als <span class="text-slate-200 font-semibold">chris</span></div>
            </div>

            <?php if ($message): ?>
                <div class="mt-4 rounded-lg border border-blue-500/40 bg-blue-500/10 text-blue-100 px-4 py-3 text-sm">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="mt-6 space-y-4">
                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="title">Titel</label>
                    <input id="title" name="title" type="text" required
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-3 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70">
                </div>
                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="content">Prompt</label>
                    <textarea id="content" name="content" rows="6" required
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-3 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70"></textarea>
                </div>
                <button type="submit"
                    class="px-6 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 font-semibold shadow-lg shadow-blue-900/30 hover:scale-[1.01] transition-transform">
                    Opslaan
                </button>
            </form>
        </section>

        <section class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-blue-900/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-400">Promptbeheer</p>
                    <h2 class="text-2xl font-semibold text-slate-50">Opgeslagen prompts</h2>
                </div>
                <a href="/generated_concept.json" class="text-sm text-blue-300 hover:text-blue-200">Bekijk laatste concept</a>
            </div>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <?php if (empty($prompts)): ?>
                    <div class="text-slate-400 text-sm">Nog geen prompts opgeslagen.</div>
                <?php else: ?>
                    <?php foreach (array_reverse($prompts) as $prompt): ?>
                        <div class="rounded-lg border border-slate-800 bg-slate-900 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-50"><?php echo htmlspecialchars($prompt['title']); ?></h3>
                                    <p class="text-xs text-slate-500 mt-1"><?php echo htmlspecialchars($prompt['created_at']); ?></p>
                                </div>
                            </div>
                            <pre class="mt-3 text-sm text-slate-200 whitespace-pre-wrap bg-slate-800/60 border border-slate-800 rounded-lg p-3"><?php echo htmlspecialchars($prompt['content']); ?></pre>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <section class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-blue-900/20">
            <h2 class="text-xl font-semibold text-slate-50 mb-3">Snelkoppelingen</h2>
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                <a href="http://localhost:8000" class="rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 px-4 py-3 font-semibold shadow-lg shadow-blue-900/30 hover:scale-[1.01] transition-transform text-center">Generator (8000)</a>
                <a href="http://localhost:8001" class="rounded-lg bg-slate-800 px-4 py-3 font-semibold shadow hover:scale-[1.01] transition-transform text-center">Viewer (8001)</a>
                <a href="/generated_concept.json" class="rounded-lg bg-slate-800 px-4 py-3 font-semibold shadow hover:scale-[1.01] transition-transform text-center">JSON Output</a>
            </div>
        </section>
    </main>
</body>
</html>

