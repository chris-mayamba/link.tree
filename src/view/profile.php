<?php
require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../model/model_links.php';

// Gestion de la session safe : ne pas redémarrer si déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Logique de récupération du username :
// 1. S'il vient du routeur (variable $username déjà définie avant l'include) -> Priorité 1 (Profil public)
// 2. Sinon, s'il est dans l'URL GET (ex: ?u=jean) -> Priorité 2
// 3. Sinon, s'il est connecté (Session) -> Priorité 3 (Mon profil)
if (!isset($username)) {
    if (isset($_GET['u'])) {
        $username = $_GET['u'];
    } elseif (isset($_SESSION['user']['username'])) {
        $username = $_SESSION['user']['username'];
    }
}

// Si aucun username n'est défini (ni routeur, ni URL, ni session), erreur
if (empty($username)) {
    // Fallback ou erreur 404
    header("HTTP/1.0 404 Not Found");
    echo "Utilisateur non spécifié.";
    exit;
}

// 1. Récupération des infos utilisateur & page
$userProfile = get_user_profile($username);

if (!$userProfile) {
    header("HTTP/1.0 404 Not Found");
    echo "Utilisateur introuvable.";
    exit;
}

// 2. Récupération des liens
// Si la page n'existe pas encore (cas rare si créé à l'inscription), on a juste userProfile mais page_id peut être null si LEFT JOIN failed ou si page pas créée.
// Mais create_user crée la page. Donc on devrait avoir page_id.
$links = [];
if (!empty($userProfile['page_id'])) {
    $links = get_links_by_page_id($userProfile['page_id']);
}

$pageTitle = $userProfile['page_title'] ?? "Profil de " . $userProfile['username'];
$jobTitle = $userProfile['job_title'] ?? "Membre LinkTree";
$bio = $userProfile['bio'] ?? "Bienvenue sur mon profil LinkTree !";
// Image par défaut si pas d'image
$profilePicture = $userProfile['profile_picture'];
if (empty($profilePicture)) {
    // Placeholder unsplash ou gravatar
    $profilePicture = "https://ui-avatars.com/api/?name=" . urlencode($userProfile['username']) . "&background=random&size=256";
}

$title = $pageTitle;
ob_start();
?>

<!-- Soft background animation for white theme -->
<div class="bg-animation fixed inset-0 pointer-events-none -z-10" aria-hidden="true">
    <div class="blob" style="background: linear-gradient(135deg, rgba(254,215,170,0.4) 0%, rgba(253,164,175,0.4) 100%);"></div>
    <div class="blob blob-2" style="background: linear-gradient(135deg, rgba(191,219,254,0.4) 0%, rgba(199,210,254,0.4) 100%);"></div>
    <div class="blob blob-3" style="background: linear-gradient(135deg, rgba(233,213,255,0.4) 0%, rgba(251,207,232,0.4) 100%);"></div>
</div>

<!-- Include Tailwind Plus Elements for dropdown -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> -->

<!-- Top Bar for Admin -->
<?php if (isset($_SESSION['user']['username']) && $_SESSION['user']['username'] === $userProfile['username']): ?>
<nav class="absolute top-0 right-0 p-4 z-50 flex items-center space-x-4">
    <!-- Add Link Button -->
    <a href="src/view/links/create.php" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Ajouter un lien
    </a>

    <!-- Profile Dropdown -->
    <div class="relative ml-3">
        <button type="button" 
                onclick="document.getElementById('user-menu').classList.toggle('hidden')"
                class="relative flex max-w-xs items-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" 
                id="user-menu-button" 
                aria-expanded="false" 
                aria-haspopup="true">
            <span class="absolute -inset-1.5"></span>
            <span class="sr-only">Open user menu</span>
            <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-200 rounded-full border-2 border-white shadow-md">
                <span class="font-medium text-gray-600 text-lg"><?= ucfirst($_SESSION['user']['username'][0]); ?></span>
            </div>
        </button>

        <!-- Dropdown menu -->
        <div id="user-menu" 
             class="hidden absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" 
             role="menu" 
             aria-orientation="vertical" 
             aria-labelledby="user-menu-button" 
             tabindex="-1">
            <!-- Profile Link -->
            <a href="/src/view/profile/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Your profile</a>
            <!-- Links Link -->
            <a href="/src/view/links.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Your links</a>
            <!-- Dashboard Link -->
            <a href="/src/view/dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Dashboard</a>
            
            <!-- Sign Out -->
            <form action="/src/view/logout.php" method="post" class="block">
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Sign out</button>
            </form>
        </div>
    </div>
</nav>

<!-- Click outside to close menu script -->
<script>
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('user-menu');
        const button = document.getElementById('user-menu-button');
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
</script>
<?php endif; ?>

<div class="min-h-screen bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8 flex flex-col items-center relative w-full">
    <!-- Card Container -->
    <div class="max-w-md w-full bg-white/80 backdrop-blur-xl border border-gray-100 rounded-3xl shadow-2xl overflow-hidden transform transition-all hover:scale-[1.01]">
        
        <!-- Header/Cover Area -->
        <style>
            @keyframes gradientFlow {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            .animate-gradient {
                background-size: 200% 200%;
                animation: gradientFlow 6s ease infinite;
            }
        </style>
        <div class="h-32 bg-gradient-to-r from-orange-200 via-rose-200 to-fuchsia-200 animate-gradient"></div>

        <!-- Profile Content -->
        <div class="relative px-6 pb-8">
            <!-- Avatar -->
            <div class="relative -mt-16 flex justify-center">
                <div class="p-1 bg-white rounded-full">
                    <img class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-sm" 
                         src="<?= htmlspecialchars($profilePicture) ?>" 
                         alt="Avatar de <?= htmlspecialchars($userProfile['username']) ?>">
                </div>
            </div>

            <!-- Name and Bio -->
            <div class="text-center mt-4">
                <h2 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($userProfile['username']) ?></h2>
                <p class="text-gray-500 font-medium italic"><?= htmlspecialchars($jobTitle) ?></p>
                <?php if (!empty($bio)): ?>
                <p class="mt-3 text-gray-600 text-sm leading-relaxed">
                    <?= nl2br(htmlspecialchars($bio)) ?>
                </p>
                <?php endif; ?>
            </div>

            <!-- Links Section -->
            <div class="mt-8 space-y-4">
                <?php if (empty($links)): ?>
                    <p class="text-center text-gray-500 text-sm">Aucun lien public pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($links as $link): ?>
                        <a target = "_blank" href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener noreferrer" class="group flex items-center p-4 bg-gray-50 rounded-xl border border-transparent transition-all hover:bg-white hover:border-blue-500 hover:shadow-md">
                            <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 bg-blue-100 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <?php if (!empty($link['icon'])): ?>
                                    <i class="<?= htmlspecialchars($link['icon']) ?>"></i> <!-- Si FontAwesome ou autre -->
                                <?php else: ?>
                                    <!-- Icône par défaut (World) -->
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                <?php endif; ?> 
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($link['title']) ?></p>
                                <p class="text-xs text-gray-500"><?= htmlspecialchars(parse_url($link['url'], PHP_URL_HOST) ?? $link['url']) ?></p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8">
                <button id="copyProfileBtn" class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-sm font-bold rounded-xl text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all active:scale-95">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                    </svg>
                    Copier le lien du profil
                </button>
            </div>
            
            <?php if (isset($_SESSION['user']['username']) && $_SESSION['user']['username'] === $userProfile['username']): ?>
                <div class="mt-4 text-center">
                    <a href="dashboard.php" class="text-sm text-gray-500 hover:text-gray-900 underline">Retour au Dashboard</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Feedback Message -->
    <div id="toast" class="fixed bottom-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-6 py-3 rounded-full shadow-2xl transition-all duration-300 opacity-0 translate-y-10 pointer-events-none">
        Lien copié dans le presse-papiers !
    </div>
    <?php include __DIR__ . '/../includes/mailtome.php'; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const copyBtn = document.getElementById('copyProfileBtn');
    const toast = document.getElementById('toast');

    if (copyBtn) {
        copyBtn.addEventListener('click', () => {
            const url = window.location.href;
            
            navigator.clipboard.writeText(url).then(() => {
                // Show toast
                toast.classList.remove('opacity-0', 'translate-y-10');
                toast.classList.add('opacity-100', 'translate-y-0');

                // Hide toast after 3 seconds
                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-y-10');
                    toast.classList.remove('opacity-100', 'translate-y-0');
                }, 3000);
            }).catch(err => {
                console.error('Erreur lors de la copie : ', err);
            });
        });
    }
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/template.php';
?>
