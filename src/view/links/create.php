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
    <title><?= $title = "Ajouter un lien" ?></title>
    <link rel="stylesheet" href="../../public/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
    /* Colorful background particles */
    .white-bg-animation {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 0;
        overflow: hidden;
    }

    .white-bg-animation .particle {
        position: absolute;
        border-radius: 9999px;
        filter: blur(60px); /* Plus de flou pour un effet diffus magnifique */
        opacity: 0.6;
        mix-blend-mode: screen; 
    }

    /* P1: Violet / Rose */
    .white-bg-animation .p1 {
        width: 400px;
        height: 400px;
        left: -5%;
        top: -5%;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.6) 0%, rgba(236, 72, 153, 0) 70%);
        animation: floatA 20s ease-in-out infinite;
    }

    /* P2: Bleu Cyan / Indigo */
    .white-bg-animation .p2 {
        width: 500px;
        height: 500px;
        right: -10%;
        top: 10%;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.5) 0%, rgba(59, 130, 246, 0) 70%);
        animation: floatB 25s ease-in-out infinite;
    }

    /* P3: Rose / Orange fort */
    .white-bg-animation .p3 {
        width: 300px;
        height: 300px;
        left: 30%;
        bottom: 10%;
        background: radial-gradient(circle, rgba(244, 63, 94, 0.5) 0%, rgba(236, 72, 153, 0) 70%);
        animation: floatC 22s ease-in-out infinite;
    }

    /* P4: Vert / Bleu */
    .white-bg-animation .p4 {
        width: 450px;
        height: 450px;
        right: 15%;
        bottom: -10%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, rgba(6, 182, 212, 0) 70%);
        animation: floatA 28s ease-in-out infinite;
    }

    @keyframes floatA {
        0% { transform: translate(0, 0) rotate(0deg) scale(1); }
        33% { transform: translate(30px, -50px) rotate(10deg) scale(1.1); }
        66% { transform: translate(-20px, 20px) rotate(-5deg) scale(0.9); }
        100% { transform: translate(0, 0) rotate(0deg) scale(1); }
    }

    @keyframes floatB {
        0% { transform: translate(0, 0) rotate(0deg) scale(1); }
        33% { transform: translate(-50px, 50px) rotate(-10deg) scale(0.9); }
        66% { transform: translate(30px, -30px) rotate(5deg) scale(1.1); }
        100% { transform: translate(0, 0) rotate(0deg) scale(1); }
    }

    @keyframes floatC {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(50px, 50px) scale(1.1); }
        100% { transform: translate(0, 0) scale(1); }
    }
    </style>
</head>
<body class="h-full">

    <!-- Subtle white particle background -->
    <div class="white-bg-animation" aria-hidden="true">
        <div class="particle p1"></div>
        <div class="particle p2"></div>
        <div class="particle p3"></div>
        <div class="particle p4"></div>
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
                <form class="space-y-6" action="#" method="POST" enctype="multipart/form-data">
                    
                    <div id="links-container" class="space-y-6">
                        <!-- Bloc Lien (Modèle) -->
                        <div class="link-group bg-gray-700/30 p-4 rounded-lg border border-gray-600 relative">
                            <!-- Titre -->
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-white">Titre du lien</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="title[]" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 placeholder-gray-400" placeholder="Mon Instagram" required>
                                </div>
                            </div>

                            <!-- URL -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-white">URL du réseau</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 text-sm text-gray-400 bg-gray-600 border border-e-0 border-gray-600 rounded-s-md">
                                        https://
                                    </span>
                                    <input type="text" name="url[]" class="rounded-none rounded-e-lg bg-gray-700 border border-gray-600 text-white focus:ring-blue-500 focus:border-blue-500 block w-full min-w-0 flex-1 text-sm p-2.5 placeholder-gray-400" placeholder="www.instagram.com/pseudo" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton Ajouter un autre lien -->
                    <button type="button" id="add-link-btn" class="w-full py-2 px-4 border-2 border-dashed border-gray-500 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:border-gray-400 hover:bg-gray-700/50 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Ajouter un autre réseau
                    </button>

                    <!-- Image Arrière-plan (File Upload) -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-white" for="file_input">Image d'arrière-plan (Optionnel)</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 1 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Cliquez pour uploader</span> ou glissez-déposez</p>
                                    <p class="text-xs text-gray-500">SVG, PNG, JPG (MAX. 800x400px)</p>
                                </div>
                                <input id="dropzone-file" name="background_image" type="file" class="hidden" accept="image/*" />
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
        document.getElementById('add-link-btn').addEventListener('click', function() {
            const container = document.getElementById('links-container');
            const newGroup = container.firstElementChild.cloneNode(true);
            
            // Réinitialiser les valeurs des champs clonés
            const inputs = newGroup.querySelectorAll('input');
            inputs.forEach(input => input.value = '');
            
            // Ajouter un bouton de suppression si ce n'est pas le premier élément
            if (!newGroup.querySelector('.remove-btn')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-btn absolute top-2 right-2 text-gray-400 hover:text-red-500';
                removeBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                removeBtn.onclick = function() {
                    newGroup.remove();
                };
                newGroup.appendChild(removeBtn);
            }
            
            container.appendChild(newGroup);
        });
    </script>
</body>
</html>