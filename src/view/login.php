<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="icon" type="image/x-icon" href="../public/favicon.ico">
  <link rel="stylesheet" href="../public/style.css">
  <script src="https://accounts.google.com/gsi/client" async defer></script>
  <script src="../public/flowbite.min.js"></script>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center">

  <div class="bg-animation">
    <div class="blob"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
  </div>

  <div class="w-full max-w-md bg-gradient-to-br from-indigo-900/70 via-indigo-700/50 to-pink-900/40 p-8 rounded-2xl shadow-2xl border border-indigo-600/40 backdrop-blur-lg ring-1 ring-indigo-400/10">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Connexion</h1>

    <form action="" method="post" class="space-y-4">
      <div>
        <label for="username" class="block mb-2 text-sm font-medium text-gray-200">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" class="bg-gradient-to-r from-gray-800/70 to-gray-800/50 border border-indigo-500/40 text-white placeholder-gray-300 text-sm rounded-lg focus:ring-2 focus:ring-indigo-400/60 focus:border-indigo-400 block w-full p-2.5 shadow-sm" />
      </div>

      <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-200">Mot de passe</label>
        <input type="password" name="password" id="password" class="bg-gradient-to-r from-gray-800/70 to-gray-800/50 border border-indigo-500/40 text-white placeholder-gray-300 text-sm rounded-lg focus:ring-2 focus:ring-indigo-400/60 focus:border-indigo-400 block w-full p-2.5 shadow-sm" />
      </div>

      <div class="flex items-center justify-between">
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white text-sm font-medium rounded-lg focus:outline-none shadow-lg transform-gpu active:scale-95">Se connecter</button>
        <a href="#" class="text-sm text-indigo-100 hover:underline">Mot de passe oublié ?</a>
      </div>

      <div class="text-center text-sm text-gray-200">ou</div>

      <div class="space-y-2">
        <!-- Bouton Google (Flowbite / Tailwind) -->
        <div id="g_id_onload" data-client_id="YOUR_GOOGLE_CLIENT_ID_HERE" data-callback="handleCredentialResponse"></div>
        <div class="g_id_signin" data-type="standard"></div>

        <!-- Fallback button styled with Tailwind (ouvre la popup Google si besoin) -->
        <button id="google-fallback" type="button" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 border border-indigo-400 bg-white/8 text-white rounded-lg hover:bg-white/12 shadow-md ring-1 ring-indigo-400/10 focus:ring-2 focus:ring-indigo-400/50">
          <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.35 11.1h-9.17v2.92h5.27c-.23 1.4-1.46 3.06-5.27 3.06-3.17 0-5.75-2.6-5.75-5.8s2.58-5.8 5.75-5.8c1.8 0 3.01.78 3.7 1.45l2.53-2.45C17.4 3.3 15.68 2.5 13 2.5 7.05 2.5 2.5 7.1 2.5 13s4.55 10.5 10.5 10.5c6.07 0 10.36-4.27 10.36-10.32 0-.7-.08-1.2-.51-1.58z"/></svg>
          Continuer avec Google
        </button>
      </div>
    </form>
  </div>

  <script>
    function handleCredentialResponse(response) {
      const formData = new FormData();
      formData.append('google_token', response.credential);

      fetch('../controllers/google_auth.php', {
        method: 'POST',
        body: formData
      }).then(r => r.json())
        .then(data => {
          if (data.success) location.href = data.redirect;
          else alert('Erreur : ' + data.message);
        }).catch(() => alert('Erreur réseau'));
    }

    // Fallback: simule un clic sur le widget signin si présent
    document.getElementById('google-fallback').addEventListener('click', function() {
      const btn = document.querySelector('.g_id_signin button');
      if (btn) btn.click();
      else alert('Widget Google non chargé — vérifiez votre Client ID');
    });
  </script>

</body>
</html>