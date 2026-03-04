<?php
session_start();
require_once __DIR__ . '/../../model/user.php';
require_once __DIR__ . '/../../model/model_links.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? null;
unset($_SESSION['errors'], $_SESSION['success']);

$userId = $_SESSION['user']['id'];
$page = get_page_by_user_id($userId);

$job_title_val = $page['job_title'] ?? '';
$bio_val = $page['bio'] ?? '';
    
$title = "Modifier Mon Profil";
ob_start();
?>

<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative z-10 w-full">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Mettre à jour mon profil
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Modifiez vos informations personnelles
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl sm:rounded-lg sm:px-10 border border-gray-100">
            
            <?php if($success): ?>
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-50 rounded-lg border border-green-200" role="alert">
                    <span class="font-medium">Succès !</span> <?= $success ?>
                </div>
            <?php endif; ?>

            <?php if(isset($errors['global'])): ?>
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-50 rounded-lg border border-red-200" role="alert">
                    <span class="font-medium">Erreur !</span> <?= $errors['global'] ?>
                </div>
            <?php endif; ?>

            <form class="space-y-6" action="../../controllers/controller_profile.php" method="POST" enctype="multipart/form-data">
                
                <div class="space-y-4">
                    <!-- Photo de profil -->
                    <div class="flex justify-center mb-6">
                        <div class="relative inline-flex items-center justify-center w-24 h-24 overflow-hidden bg-gray-100 rounded-full flex-shrink-0 border border-gray-200 shadow-sm">
                            <?php if(!empty($page['profile_picture'])): ?>
                                <img id="avatar-preview" src="<?= htmlspecialchars($page['profile_picture']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <img id="avatar-preview" src="../../assets/favicon.png" class="w-full h-full object-cover hidden">
                                <i id="avatar-placeholder" class="fa-solid fa-user text-gray-400 text-3xl"></i>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Photo de profil</label>
                        <input type="file" name="profile_picture" id="profile_picture_input" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Métier / Titre</label>
                        <input type="text" name="job_title" value="<?= htmlspecialchars($job_title_val) ?>" placeholder="Ex: Développeur Web Fullstack" 
                            class="bg-gray-50 border <?= isset($errors['job_title']) ? 'border-red-500' : 'border-gray-200' ?> text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <?php if(isset($errors['job_title'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= $errors['job_title'] ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Biographie courte</label>
                        <textarea name="bio" rows="4" placeholder="Un petit mot sur vous..." 
                            class="bg-gray-50 border <?= isset($errors['bio']) ? 'border-red-500' : 'border-gray-200' ?> text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"><?= htmlspecialchars($bio_val) ?></textarea>
                        <?php if(isset($errors['bio'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= $errors['bio'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <a href="../profile.php" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        ← Retour au profil
                    </a>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all shadow-md hover:shadow-lg">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('profile_picture_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<?php
$content = ob_get_clean();
// Include the main template correctly
include __DIR__ . '/../template.php'; 
?>