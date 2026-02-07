<?php session_start(); 
if (!isset($_SESSION['user'])) {
    
    header('Location: ../view/login.php');
};
?>

<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title = "Dashboard"?></title>
    <link rel="stylesheet" href="../public/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
    <style>
    /* Discreet white background particles */
    .white-bg-animation {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 0;
        overflow: hidden;
    }

    .white-bg-animation .particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 9999px;
        filter: blur(6px);
        opacity: 0.08;
        mix-blend-mode: screen;
    }

    .white-bg-animation .p1 {
        width: 160px;
        height: 160px;
        left: 8%;
        top: 12%;
        animation: floatA 28s ease-in-out infinite;
    }

    .white-bg-animation .p2 {
        width: 220px;
        height: 220px;
        right: 6%;
        top: 20%;
        animation: floatB 32s ease-in-out infinite;
        opacity: 0.06;
    }

    .white-bg-animation .p3 {
        width: 120px;
        height: 120px;
        left: 40%;
        bottom: 8%;
        animation: floatC 26s ease-in-out infinite;
        opacity: 0.05;
    }

    .white-bg-animation .p4 {
        width: 300px;
        height: 300px;
        right: 18%;
        bottom: 18%;
        animation: floatA 36s ease-in-out infinite;
        opacity: 0.04;
    }

    @keyframes floatA {
        0% {
            transform: translateY(0) translateX(0) scale(1);
        }

        50% {
            transform: translateY(-30px) translateX(10px) scale(1.03);
        }

        100% {
            transform: translateY(0) translateX(0) scale(1);
        }
    }

    @keyframes floatB {
        0% {
            transform: translateY(0) translateX(0) scale(1);
        }

        50% {
            transform: translateY(40px) translateX(-20px) scale(0.98);
        }

        100% {
            transform: translateY(0) translateX(0) scale(1);
        }
    }

    @keyframes floatC {
        0% {
            transform: translateY(0) translateX(0) scale(1);
        }

        50% {
            transform: translateY(-20px) translateX(18px) scale(1.02);
        }

        100% {
            transform: translateY(0) translateX(0) scale(1);
        }
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</head>

<body class="h-full">
    <!-- Subtle white particle background -->
    <div class="white-bg-animation" aria-hidden="true">
        <div class="particle p1"></div>
        <div class="particle p2"></div>
        <div class="particle p3"></div>
        <div class="particle p4"></div>
    </div>
    <!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
    <!--  -->
    <div class="min-h-full">
        <nav class="bg-gray-800/50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <img src="../assets/logo.png"
                                alt="Your Company" class="size-8" />
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                                <a href="links.php"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                                    My links
                                </a>
                                <a href="dashboard.php" aria-current="page"
                                    class="rounded-md bg-gray-950/50 px-3 py-2 text-sm font-medium text-white">
                                    Dashboard
                                </a>
                                <a href="#"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                                    Projects
                                </a>
                                <a href="#"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                                    Calendar
                                </a>
                                <a href="#"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                                    Reports
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <button type="button"
                                class="relative rounded-full p-1 text-gray-400 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
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
                                    class="relative flex max-w-xs items-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <div
                                        class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-neutral-tertiary rounded-full">
                                        <span
                                            class="font-medium text-body"><?=  ucfirst($_SESSION['user'][0]); ?></span>
                                    </div>
                                </button>

                                <el-menu anchor="bottom end" popover
                                    class="w-48 origin-top-right rounded-md bg-gray-800 py-1 outline-1 -outline-offset-1 outline-white/10 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:outline-hidden">
                                        Your
                                        profile</a>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:outline-hidden">
                                        Settings
                                    </a>
                                    <form action="logout.php" method="post">
                                        <button type="submit"
                                            class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:outline-hidden">
                                            Sign out</button>
                                    </form>
                                </el-menu>
                            </el-dropdown>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" command="--toggle" commandfor="mobile-menu"
                            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
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
                    <a href="#"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                        Projects
                    </a>
                    <a href="#"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                        Calendar
                    </a>
                    <a href="#"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                        Reports
                    </a>
                </div>
                <div class="border-t border-white/10 pt-4 pb-3">
                    <div class="flex items-center px-5">
                        <div class="shrink-0">
                            <div
                                class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-neutral-tertiary rounded-full">
                                <span class="font-medium text-body">JL</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base/5 font-medium text-white">Tom Cook</div>
                            <div class="text-sm font-medium text-gray-400">tom@example.com</div>
                        </div>
                        <button type="button"
                            class="relative ml-auto shrink-0 rounded-full p-1 text-gray-400 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
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
                        <a href="#"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Your
                            profile</a>
                        <a href="#"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Settings</a>
                        <form action="logout.php" method="post">
                            <button type="submit"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </el-disclosure>
        </nav>

        <header
            class="relative bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-white"><?= $title ?></h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <!-- Your content -->
            </div>
        </main>
    </div>
</body>