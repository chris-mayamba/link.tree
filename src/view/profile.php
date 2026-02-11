<?php
$title = "Profil de " . (isset($username) ? htmlspecialchars($username) : "Utilisateur");
ob_start();
?>

<div class="min-h-screen bg-linear-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8 flex flex-col items-center">
    <!-- Card Container -->
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all hover:scale-[1.01]">
        
        <!-- Header/Cover Area -->
        <div class="h-32 bg-linear-to-r from-blue-500 to-purple-600"></div>

        <!-- Profile Content -->
        <div class="relative px-6 pb-8">
            <!-- Avatar -->
            <div class="relative -mt-16 flex justify-center">
                <div class="p-1 bg-white rounded-full">
                    <img class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-sm" 
                         src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&auto=format&fit=crop&w=256&h=256&q=80" 
                         alt="Avatar">
                </div>
            </div>

            <!-- Name and Bio -->
            <div class="text-center mt-4">
                <h2 class="text-2xl font-bold text-gray-900"><?= isset($username) ? htmlspecialchars($username) : "Jean Dupont" ?></h2>
                <p class="text-gray-500 font-medium italic">Développeur Web Fullstack</p>
                <p class="mt-3 text-gray-600 text-sm leading-relaxed">
                    Passionné par la création d'expériences numériques élégantes et performantes. Retrouvez-moi sur mes différents réseaux !
                </p>
            </div>

            <!-- Links Section -->
            <div class="mt-8 space-y-4">
                <!-- Single Link Item -->
                <a href="#" class="group flex items-center p-4 bg-gray-50 rounded-xl border border-transparent transition-all hover:bg-white hover:border-blue-500 hover:shadow-md">
                    <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 bg-blue-100 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-semibold text-gray-900">GitHub</p>
                        <p class="text-xs text-gray-500">github.com/jeandupont</p>
                    </div>
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="#" class="group flex items-center p-4 bg-gray-50 rounded-xl border border-transparent transition-all hover:bg-white hover:border-blue-400 hover:shadow-md">
                    <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 bg-blue-50 text-blue-500 rounded-lg group-hover:bg-blue-500 group-hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-semibold text-gray-900">LinkedIn</p>
                        <p class="text-xs text-gray-500">linkedin.com/in/jeandupont</p>
                    </div>
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Action Button -->
            <div class="mt-8">
                <button id="copyProfileBtn" class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-sm font-bold rounded-xl text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all active:scale-95">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                    </svg>
                    Copier le lien du profil
                </button>
            </div>
        </div>
    </div>

    <!-- Feedback Message -->
    <div id="toast" class="fixed bottom-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-6 py-3 rounded-full shadow-2xl transition-all duration-300 opacity-0 translate-y-10 pointer-events-none">
        Lien copié dans le presse-papiers !
    </div>
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
