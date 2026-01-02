<?php
session_start();

$USERNAME = 'chris';
$PASSWORD = 'Orderli123';

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header('Location: /admin_dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if ($user === $USERNAME && $pass === $PASSWORD) {
        $_SESSION['admin'] = true;
        header('Location: /admin_dashboard.php');
        exit;
    } else {
        $error = 'Ongeldige inloggegevens';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-50 min-h-screen flex items-center justify-center">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 via-purple-500/10 to-pink-500/10 blur-3xl"></div>
    <div class="relative w-full max-w-md">
        <div class="bg-slate-900 border border-slate-800/80 rounded-2xl shadow-2xl shadow-blue-900/20 p-8 backdrop-blur">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-xl font-bold">A</div>
                <div>
                    <p class="text-sm text-slate-400">Orderli Admin</p>
                    <h1 class="text-2xl font-bold text-slate-50">Dashboard login</h1>
                </div>
            </div>

            <?php if ($error): ?>
                <div class="mb-4 rounded-lg border border-red-500/40 bg-red-500/10 text-red-200 px-4 py-3 text-sm">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="username">Gebruikersnaam</label>
                    <input id="username" name="username" type="text" required
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-3 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70">
                </div>
                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="password">Wachtwoord</label>
                    <input id="password" name="password" type="password" required
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-3 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70">
                </div>
                <button type="submit"
                    class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 font-semibold shadow-lg shadow-blue-900/30 hover:scale-[1.01] transition-transform">
                    Inloggen
                </button>
            </form>
        </div>
        <p class="mt-4 text-center text-xs text-slate-500">Gebruik: chris / Orderli123</p>
    </div>
</body>
</html>

