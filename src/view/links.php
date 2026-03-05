<?php session_start(); 
require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../model/model_links.php';

if (!isset($_SESSION['user'])) {
    
    header('Location: ../view/login.php');
    exit;
};

// Récupération des liens
$userId = $_SESSION['user']['id'];
$page = get_page_by_user_id($userId); // Assurez-vous que cette fonction existe dans user.php
$links = [];
if ($page) {
    $links = get_links_by_page_id($page['id']); 
}

$current = "rounded-md bg-gray-100 px-3 py-2 text-sm font-medium text-gray-900";
$same = "rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900";

$current_mobile = "block rounded-md bg-gray-100 px-3 py-2 text-base font-medium text-gray-900";
$same_mobile = "block rounded-md px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900";
?>

<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title = "Links"?></title>
    <link rel="stylesheet" href="../public/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</head>

<body class="h-full text-gray-900 bg-gray-50">
    <!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
    <!--  -->
    <div class="min-h-full">
        <nav class="bg-white border-b border-gray-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <img src="../assets/logo.png"
                                alt="Link.Tree logo" class="size-8" style="filter: invert(1);" />
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                                <a href="links.php" class="<?= $title === "Links" ? $current : $same;?>">
                                    My links
                                </a>
                                <a href="dashboard.php" aria-current="page"
                                    class="hidden <?= $title === "Dashboard" ? $current : $same;?>">
                                    Dashboard
                                </a>
                                <a href="/<?= htmlspecialchars($_SESSION['user']['username']) ?>"
                                    class="<?= $title === "Dashboard" ? $current : $same;?>">
                                    Profile
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <button type="button"
                                class="relative rounded-full p-1 text-gray-400 hover:text-gray-500 focus:outline-2 focus:outline-offset-2 focus:outline-gray-900">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">View notifications</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    data-slot="icon" aria-hidden="true" class="size-6">
                                    <path
                                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>

                            <!-- Profile dropdown -->
                            <el-dropdown class="relative ml-3">
                                <button
                                    class="relative flex max-w-xs items-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <div
                                        class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 border border-gray-200 rounded-full text-gray-600 hover:bg-gray-200">
                                        <span
                                            class="font-medium text-body"><?=  ucfirst($_SESSION['user']['username'][0]); ?></span>
                                    </div>
                                </button>

                                <el-menu anchor="bottom end" popover
                                    class="w-48 origin-top-right rounded-md bg-white border border-gray-200 py-1 shadow-lg ring-1 ring-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                                    <a href="/src/view/profile/profile.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 focus:bg-gray-50 focus:outline-hidden">
                                        Your profile</a>
                                    <a href="/src/view/links.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 focus:bg-gray-50 focus:outline-hidden">
                                        Your links</a>
                                    <a href="/src/view/dashboard.php"
                                        class="hidden block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 focus:bg-gray-50 focus:outline-hidden">
                                        Dashboard</a>
                                    <!-- Future Dark Mode Toggle -->
                                    <button type="button" disabled class="w-full text-left block px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
                                        Dark Mode (Bientôt)
                                    </button>
                                    <form action="logout.php" method="post">
                                        <button type="submit"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 focus:bg-gray-50 focus:outline-hidden">
                                            Sign out</button>
                                    </form>
                                </el-menu>
                            </el-dropdown>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" command="--toggle" commandfor="mobile-menu"
                            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-2 focus:outline-offset-2 focus:outline-gray-900">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                                <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                                <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <el-disclosure id="mobile-menu" hidden class="block md:hidden">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                    <a href="links.php"
                        class="<?= $title === "Links" ? $current_mobile : $same_mobile;?>">
                        My links
                    </a>
                    <a href="dashboard.php" aria-current="page"
                        class="hidden <?= $title === "Dashboard" ? $current_mobile : $same_mobile;?>">
                        Dashboard
                    </a>
                </div>
                <div class="border-t border-gray-200 pt-4 pb-3">
                    <div class="flex items-center px-5">
                        <div class="shrink-0">
                            <div
                                class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full border border-gray-200">
                                <span class="font-medium text-gray-600"><?= ucfirst($_SESSION['user']['username'][0]); ?></span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base/5 font-medium text-gray-800"><?= htmlspecialchars($_SESSION['user']['username']) ?></div>
                            <div class="text-sm font-medium text-gray-500"><?= htmlspecialchars($_SESSION['user']['email']) ?></div>
                        </div>
                        <button type="button"
                            class="relative ml-auto shrink-0 rounded-full p-1 text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                data-slot="icon" aria-hidden="true" class="size-6">
                                <path
                                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <a href="/src/view/profile/profile.php"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Your profile</a>
                        <a href="/src/view/links.php"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Your links</a>
                        <a href="/src/view/dashboard.php"
                            class="hidden block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Dashboard</a>
                        <!-- Future Dark Mode Toggle -->
                        <button type="button" disabled class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-400 cursor-not-allowed">
                            Dark Mode (Bientôt)
                        </button>
                        <form action="logout.php" method="post">
                            <button type="submit"
                                class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </el-disclosure>
        </nav>

        <header
            class="relative bg-white after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-gray-200">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900"><?= $title ?></h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <!-- Header avec bouton d'ajout -->
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h2 class="text-base font-semibold leading-6 text-gray-900">Vos liens</h2>
                        <p class="mt-2 text-sm text-gray-700">Une liste de tous les liens de votre page, y compris leur titre, URL et statut.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a href="links/create.php" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajouter un lien</a>
                    </div>
                </div>

                <!-- Tableau des liens -->
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Titre</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">URL</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <?php if (empty($links)): ?>
                                            <tr>
                                                <td colspan="4" class="py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-6 text-center">Aucun lien trouvé. Commencez par en ajouter un !</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($links as $link): ?>
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                        <div class="flex items-center">
                                                            <?php if ($link['icon']): ?>
                                                                <div class="h-8 w-8 flex-shrink-0 mr-3">
                                                                    <!-- Affichage simple de l'icône si c'est une image ou une classe -->
                                                                    <?php if (strpos($link['icon'], 'http') === 0 || strpos($link['icon'], '/') === 0): ?>
                                                                        <img class="h-8 w-8 rounded-full" src="<?= htmlspecialchars($link['icon']) ?>" alt="">
                                                                    <?php else: ?>
                                                                        <span class="<?= htmlspecialchars($link['icon']) ?>"></span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                            <div><?= htmlspecialchars($link['title']) ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="text-indigo-600 hover:text-indigo-900 truncate max-w-xs block"><?= htmlspecialchars($link['url']) ?></a>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        <?php if ($link['is_active']): ?>
                                                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Actif</span>
                                                        <?php else: ?>
                                                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Inactif</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        <a href="links/edit.php?id=<?= $link['id'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-4">Modifier</a>
                                                        <form action="../controllers/controller_links.php" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce lien ?');">
                                                            <input type="hidden" name="action" value="delete">
                                                            <input type="hidden" name="id" value="<?= $link['id'] ?>">
                                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent border-0 cursor-pointer p-0">Supprimer</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
