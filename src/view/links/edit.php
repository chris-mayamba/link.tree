<?php session_start(); 
require_once __DIR__ . '/../../model/user.php';
require_once __DIR__ . '/../../model/model_links.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: ../links.php');
    exit;
}

$linkId = $_GET['id'];
$link = get_link_by_id($linkId);
$userId = $_SESSION['user']['id'];
$page = get_page_by_user_id($userId);

// Vérification que le lien appartient bien à la page de l'utilisateur
if (!$link || $link['page_id'] !== $page['id']) {
    header('Location: ../links.php');
    exit;
}

$errors = $_SESSION['errors'] ?? [];
$old_inputs = $_SESSION['old_inputs'] ?? [];
unset($_SESSION['errors'], $_SESSION['old_inputs']);

// Pré-remplissage
$title = $old_inputs['title'] ?? $link['title'];
$url = $old_inputs['url'] ?? $link['url'];
$icon = $old_inputs['icon'] ?? $link['icon'];
$isActive = isset($old_inputs['is_active']) ? $old_inputs['is_active'] : $link['is_active'];

?>
<!DOCTYPE html>
<html lang="fr" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= "Modifier le lien" ?></title>
    <link rel="stylesheet" href="../../public/style.css">
    <link rel="shortcut icon" href="../../assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../../public/flowbite.min.js"></script>
</head>
<body class="h-full text-gray-900">

    <div class="bg-animation fixed inset-0 pointer-events-none" aria-hidden="true">
        <div class="blob" style="background: linear-gradient(135deg, rgba(59,130,246,0.2) 0%, rgba(14,165,233,0.2) 100%); filter: blur(80px);"></div>
        <div class="blob blob-2" style="background: linear-gradient(135deg, rgba(37,99,235,0.15) 0%, rgba(96,165,250,0.15) 100%); left:20%; top:15%;"></div>
    </div>

    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative z-10">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Modifier le lien
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-lg sm:px-10 border border-gray-100">
                <?php if(isset($_SESSION['errors']['global'])): ?>
                    <div class="mb-4 p-4 text-sm text-red-500 bg-red-50 rounded-lg border border-red-200" role="alert">
                        <span class="font-medium">Erreur !</span> <?= $_SESSION['errors']['global'] ?>
                    </div>
                    <?php unset($_SESSION['errors']['global']); ?>
                <?php endif; ?>
                
                <form class="space-y-6" action="../../controllers/controller_links.php" method="POST">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?= $link['id'] ?>">

                    <!-- Titre -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Titre du lien</label>
                        <div class="relative">
                            <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" class="bg-white border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                    </div>

                    <!-- URL -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">URL</label>
                        <div class="relative">
                            <input type="text" name="url" value="<?= htmlspecialchars($url) ?>" class="bg-white border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                    </div>

                    <!-- Icone (Caché ou visible pour modif avancée) -->
                    <input type="hidden" name="icon" value="<?= htmlspecialchars($icon ?? '') ?>">

                    <!-- Statut -->
                    <div class="flex items-center mb-4">
                        <input id="is_active" type="checkbox" name="is_active" value="1" <?= $isActive ? 'checked' : '' ?> class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_active" class="ms-2 text-sm font-medium text-gray-900">Lien actif</label>
                    </div>

                    <!-- Boutons -->
                    <div class="flex items-center justify-between space-x-4 pt-4">
                        <a href="../links.php" class="w-full text-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors shadow-lg">
                            Mettre à jour
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
