<?php session_start(); 
require_once __DIR__ . '/../../model/user.php';
require_once __DIR__ . '/../../model/model_links.php';

if (!isset($_SESSION['user'])) {
    
    header('Location: ../login.php');
    exit;
};

$errors = $_SESSION['errors'] ?? [];
$old_inputs = $_SESSION['old_inputs'] ?? [];
unset($_SESSION['errors'], $_SESSION['old_inputs']);

// Initialisation
$titles = [];
$urls = [];
$job_title_val = '';
$bio_val = '';

// 1. Cas : Retour d'erreur, on reprend les inputs envoyés
if (!empty($old_inputs)) {
    $titles = $old_inputs['title'] ?? [];
    $urls = $old_inputs['url'] ?? [];
    $job_title_val = $old_inputs['job_title'] ?? '';
    $bio_val = $old_inputs['bio'] ?? '';
} 
// 2. Cas : Chargement des données existantes depuis la DB
else {
    $userId = $_SESSION['user']['id'];
    $page = get_page_by_user_id($userId);
    
    if ($page) {
        $job_title_val = $page['job_title'] ?? '';
        $bio_val = $page['bio'] ?? '';
        
        $links = get_links_by_page_id($page['id']);
        if ($links) {
            foreach($links as $link) {
                $titles[] = $link['title'];
                $urls[] = $link['url'];
            }
        }
    }
}

// Fallback : au moins un champ vide pour démarrer
if (empty($titles)) {
    $titles = [''];
    $urls = [''];
}

$count = max(count($titles), count($urls));
?>
<!DOCTYPE html>
<html lang="fr" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title = "Ajouter un lien" ?></title>
    <link rel="stylesheet" href="../../public/style.css">
    <link rel="shortcut icon" href="../../assets/favicon.png" type="image/x-icon">
    <!-- FontAwesome for fallback and manual icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../../public/flowbite.min.js"></script>
</head>
<body class="h-full text-gray-900">

    <!-- Blue background animation -->
    <div class="bg-animation fixed inset-0 pointer-events-none" aria-hidden="true">
        <div class="blob" style="background: linear-gradient(135deg, rgba(59,130,246,0.2) 0%, rgba(14,165,233,0.2) 100%); filter: blur(80px);"></div>
        <div class="blob blob-2" style="background: linear-gradient(135deg, rgba(37,99,235,0.15) 0%, rgba(96,165,250,0.15) 100%); left:20%; top:15%;"></div>
        <div class="blob blob-3" style="background: linear-gradient(135deg, rgba(59,130,246,0.1) 0%, rgba(99,102,241,0.1) 100%); right:10%; bottom:5%; filter: blur(100px);"></div>
    </div>

    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative z-10">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                Créer un nouveau lien
            </h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Ajoutez vos réseaux et personnalisez l'affichage
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-700">
                <?php if(isset($_SESSION['errors']['global'])): ?>
                    <div class="mb-4 p-4 text-sm text-red-500 bg-red-100 rounded-lg border border-red-200" role="alert">
                        <span class="font-medium">Erreur !</span> <?= $_SESSION['errors']['global'] ?>
                    </div>
                    <?php unset($_SESSION['errors']['global']); ?>
                <?php endif; ?>
                <form 
                    class="space-y-6" 
                    action="../../controllers/controller_links.php" 
                    method="POST" 
                    enctype="multipart/form-data">
                    
                    <!-- SECTION PROFIL (Correspondance Table Pages) -->
                    <div class="space-y-4 border-b border-gray-700 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-white flex items-center gap-2">
                            <i class="fa-solid fa-user-gear text-blue-500"></i> Votre Profil
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-white">Métier / Titre</label>
                                <input type="text" name="job_title" value="<?= htmlspecialchars($job_title_val) ?>" placeholder="Ex: Développeur Web Fullstack" 
                                    class="bg-gray-700 border <?= isset($errors['job_title']) ? 'border-red-500' : 'border-gray-600' ?> text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <?php if(isset($errors['job_title'])): ?>
                                    <p class="mt-2 text-sm text-red-500"><?= $errors['job_title'] ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div>
                                <label class="block mb-2 text-sm font-medium text-white">Biographie courte</label>
                                <textarea name="bio" rows="2" placeholder="Un petit mot sur vous..." 
                                    class="bg-gray-700 border <?= isset($errors['bio']) ? 'border-red-500' : 'border-gray-600' ?> text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"><?= htmlspecialchars($bio_val) ?></textarea>
                                <?php if(isset($errors['bio'])): ?>
                                    <p class="mt-2 text-sm text-red-500"><?= $errors['bio'] ?></p>
                                <?php endif; ?>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-white">Photo de profil</label>
                                <div class="flex items-center gap-4">
                                    <div class="relative inline-flex items-center justify-center w-12 h-12 overflow-hidden bg-gray-600 rounded-full flex-shrink-0">
                                        <img id="avatar-preview" src="../../assets/favicon.png" class="w-full h-full object-cover hidden">
                                        <i id="avatar-placeholder" class="fa-solid fa-user text-gray-400"></i>
                                    </div>
                                    <input type="file" name="profile_picture" id="profile_picture_input" accept="image/*"
                                        class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="links-container" class="space-y-6">
                        <?php for($i = 0; $i < $count; $i++): 
                            $valTitle = $titles[$i] ?? '';
                            $valUrl = $urls[$i] ?? '';
                            $errTitle = $errors['title'][$i] ?? null;
                            $errUrl = $errors['url'][$i] ?? null;
                        ?>
                        <!-- Bloc Lien (Modèle) -->
                        <div class="link-group bg-gray-700/30 p-4 rounded-lg border border-gray-600 relative">
                            <?php if($i > 0): ?>
                            <button type="button" class="remove-btn absolute top-2 right-2 text-gray-400 hover:text-red-500" onclick="this.closest('.link-group').remove()">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            <?php endif; ?>

                            <!-- Titre -->
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-white flex justify-between">
                                    Titre du lien
                                    <span class="icon-preview flex items-center gap-2 text-xs font-normal text-gray-400">
                                        Icône suggérée : <img src="../../assets/favicon.png" class="w-4 h-4 rounded-sm icon-img opacity-0 transition-opacity">
                                    </span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="title[]" 
                                        value="<?= htmlspecialchars($valTitle) ?>"
                                        class="title-input bg-gray-700 border <?= $errTitle ? 'border-red-500' : 'border-gray-600' ?> text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 placeholder-gray-400" 
                                        placeholder="Mon Instagram" 
                                        required>
                                </div>
                                <?php if($errTitle): ?>
                                    <p class="mt-2 text-sm text-red-500"><?= $errTitle ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- URL -->
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-white">URL du réseau</label>
                                <div class="flex">
                                    <span 
                                        class="inline-flex items-center px-3 text-sm text-gray-400 bg-gray-600 border border-e-0 border-gray-600 rounded-s-md">
                                        https://
                                    </span>
                                    <input 
                                        type="text" 
                                        name="url[]" 
                                        value="<?= htmlspecialchars($valUrl) ?>"
                                        class="url-input rounded-none rounded-e-lg bg-gray-700 border <?= $errUrl ? 'border-red-500' : 'border-gray-600' ?> text-white focus:ring-blue-500 focus:border-blue-500 block w-full min-w-0 flex-1 text-sm p-2.5 placeholder-gray-400" 
                                        placeholder="www.instagram.com/pseudo" 
                                        required>
                                </div>
                                <?php if($errUrl): ?>
                                    <p class="mt-2 text-sm text-red-500"><?= $errUrl ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- Champ caché pour stocker l'icône automatiquement trouvée -->
                            <input type="hidden" name="icon[]" class="icon-input">
                        </div>
                        <?php endfor; ?>
                    </div>

                    <!-- Bouton Ajouter un autre lien -->
                    <button type="button" id="add-link-btn" class="w-full py-2 px-4 border-2 border-dashed border-gray-500 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:border-gray-400 hover:bg-gray-700/50 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Ajouter un autre réseau
                    </button>

                    <!-- Image Arrière-plan (File Upload) -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-white" for="file_input">Image d'arrière-plan (Désactivé temporairement)</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-600 border-dashed rounded-lg cursor-not-allowed bg-gray-800 opacity-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 1 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Upload désactivé</span></p>
                                    <p class="text-xs text-gray-600">SVG, PNG, JPG (MAX. 800x400px)</p>
                                </div>
                                <input id="dropzone-file" name="background_image" type="file" class="hidden" accept="image/*" disabled />
                            </label>
                        </div> 
                    </div>

                    <!-- Boutons -->
                    <div class="flex items-center justify-between space-x-4 pt-4">
                        <a href="../links.php" class="w-full text-center py-2.5 px-4 border border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Retour
                        </a>
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Enregistrer le lien
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview pour la photo de profil
        document.getElementById('profile_picture_input').addEventListener('change', function(e) {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Fonction pour chercher/deviner l'icône sur le web
        function updateIconPreview(group) {
            const titleInput = group.querySelector('.title-input');
            const urlInput = group.querySelector('.url-input');
            const iconInput = group.querySelector('.icon-input');
            const iconImg = group.querySelector('.icon-img');

            const valTitle = titleInput.value.toLowerCase();
            const valUrl = urlInput.value.toLowerCase();

            let domain = '';
            
            // Essayer de deviner le domaine via l'URL
            if (valUrl.includes('.')) {
                domain = valUrl.split('/')[0];
            } else if (valTitle) {
                // Sinon via le titre
                const socialNetworks = ['instagram', 'facebook', 'github', 'linkedin', 'twitter', 'tiktok', 'youtube', 'twitch', 'spotify'];
                socialNetworks.forEach(sn => {
                    if (valTitle.includes(sn)) domain = sn + '.com';
                });
            }

            if (domain) {
                const iconUrl = `https://www.google.com/s2/favicons?domain=${domain}&sz=64`;
                iconImg.src = iconUrl;
                iconImg.classList.remove('opacity-0');
                if (!iconInput.value) {
                    iconInput.value = iconUrl; // Pré-remplir si vide
                }
            } else {
                iconImg.classList.add('opacity-0');
            }
        }

        // Délégation d'événements pour les inputs existants et futurs
        document.getElementById('links-container').addEventListener('input', function(e) {
            if (e.target.classList.contains('title-input') || e.target.classList.contains('url-input')) {
                const group = e.target.closest('.link-group');
                updateIconPreview(group);
            }
        });

        document.getElementById('add-link-btn').addEventListener('click', function() {
            const container = document.getElementById('links-container');
            const newGroup = container.firstElementChild.cloneNode(true);
            
            // Réinitialiser les valeurs des champs clonés
            const inputs = newGroup.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.value = '';
                input.classList.remove('border-red-500');
                if (input.classList.contains('bg-gray-700')) input.classList.add('border-gray-600');
            });

            // Réinitialiser l'icône preview
            const iconImg = newGroup.querySelector('.icon-img');
            iconImg.src = '../../assets/favicon.png';
            iconImg.classList.add('opacity-0');

            // Supprimer les messages d'erreur du clone
            newGroup.querySelectorAll('p.text-red-500').forEach(el => el.remove());
            
            // Gestion du bouton de suppression
            if (!newGroup.querySelector('.remove-btn')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-btn absolute top-2 right-2 text-gray-400 hover:text-red-500';
                removeBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                removeBtn.onclick = function() {
                    newGroup.remove();
                };
                newGroup.appendChild(removeBtn);
            } else {
                newGroup.querySelector('.remove-btn').onclick = function() {
                    newGroup.remove();
                };
            }
            
            container.appendChild(newGroup);
        });
    </script>
</body>
</html>