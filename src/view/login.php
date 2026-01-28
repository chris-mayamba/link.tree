<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-900">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="icon" type="image/x-icon" href="../public/favicon_clair.ico">
  <link rel="stylesheet" href="../public/style.css">
  <script src="../public/flowbite.min.js"></script>
</head>
<body class="h-full">

  <!-- Blue background animation (kept) -->
  <div class="bg-animation fixed inset-0 pointer-events-none" aria-hidden="true">
    <div class="blob" style="background: linear-gradient(135deg, rgba(59,130,246,0.2) 0%, rgba(14,165,233,0.2) 100%); filter: blur(80px);"></div>
    <div class="blob blob-2" style="background: linear-gradient(135deg, rgba(37,99,235,0.15) 0%, rgba(96,165,250,0.15) 100%); left:20%; top:15%;"></div>
    <div class="blob blob-3" style="background: linear-gradient(135deg, rgba(59,130,246,0.1) 0%, rgba(99,102,241,0.1) 100%); right:10%; bottom:5%; filter: blur(100px);"></div>
  </div>

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img src="../public/logo_clair.png" alt="Logo" class="mx-auto h-12 w-auto" />
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Sign in</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form action="#" method="POST" class="space-y-6 border border-indigo-500/30 rounded-xl p-6 backdrop-blur-sm bg-white/5">
      <div>
        <label for="email" class="block text-sm/6 font-medium text-gray-100">Email address</label>
        <div class="mt-2">
          <input id="email" type="email" name="email" required autocomplete="email" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-gray-100">Password</label>
          <div class="text-sm">
            <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Forgot password?</a>
          </div>
        </div>
        <div class="mt-2">
          <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
        </div>
      </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign in</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6 text-gray-400">
      Nouveau?
      <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Créer un compte</a>
    </p>
  </div>
</div>

</body>
</html>