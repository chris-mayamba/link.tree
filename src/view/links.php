<?php session_start(); 

if (!isset($_SESSION['user'])) {
    
    header('Location: ../view/login.php');
};

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
                                    class="<?= $title === "Dashboard" ? $current : $same;?>">
                                    Dashboard
                                </a>
                                <a href="/<?= htmlspecialchars($_SESSION['user']['username']) ?>"
                                    class="<?= $title === "Dashboard" ? $current : $same;?>">
                                    Profile
                                </a>
                                <a href="/src/view/profile/profile.php"
                                    class="invisible rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                    Calendar
                                </a>
                                <a href="/src/view/profile/profile.php"
                                    class="invisible rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                    Reports
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
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 focus:bg-gray-50 focus:outline-hidden">
                                        Dashboard</a>
                                    <a href="/src/view/profile/profile.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 focus:bg-gray-50 focus:outline-hidden">
                                        Settings
                                    </a>
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
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                        My links
                    </a>
                    <a href="dashboard.php" aria-current="page"
                        class="block rounded-md bg-gray-950/50 px-3 py-2 text-base font-medium text-white">
                        Dashboard
                    </a>
                    <a href="/src/view/profile/profile.php"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                        Projects
                    </a>
                    <a href="/src/view/profile/profile.php"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                        Calendar
                    </a>
                    <a href="/src/view/profile/profile.php"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                        Reports
                    </a>
                </div>
                <div class="border-t border-gray-200 pt-4 pb-3">
                    <div class="flex items-center px-5">
                        <div class="shrink-0">
                            <div
                                class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full border border-gray-200">
                                <span class="font-medium text-gray-600">JL</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base/5 font-medium text-gray-800">Tom Cook</div>
                            <div class="text-sm font-medium text-gray-500">tom@example.com</div>
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
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Dashboard</a>
                        <a href="/src/view/profile/profile.php"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900">Settings</a>
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
                <!-- Big create link button -->
                <div class="flex justify-center">
                    <a href="links/create.php" class="inline-flex items-center justify-center rounded-2xl text-white px-12 py-5 text-xl font-semibold shadow-2xl transition-all min-w-[300px] bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:from-teal-500 hover:to-teal-700 focus:ring-4 focus:outline-none focus:ring-teal-300">
                        <svg class="w-6 h-6 mr-2 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span class="leading-none">Créer un lien</span>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
