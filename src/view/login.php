<?php
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user'])) {
  header('Location: profile.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ="Connexion" ?></title>
  <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
  <link rel="stylesheet" href="../public/style.css">
  <script src="../public/flowbite.min.js"></script>
</head>
<body class="h-full">

<div class="flex min-h-full flex-col justify-center px-4 py-12 sm:px-6 lg:px-8 bg-gray-50">
  <div class="sm:mx-auto sm:w-full sm:max-w-xl">
    <div class="mb-6 flex flex-col items-start">
      <h2 class="text-xl font-bold tracking-tight text-gray-900">Sign in to your account</h2>
      <p class="mt-1 text-sm text-gray-500">Welcome back! Please enter your details.</p>
    </div>

    <?php if (isset($_SESSION['badge'])): ?>
      <div class="mt-4 text-center">
        <?php if ($_SESSION['badge']['type'] === 'success'): ?>
          <span class="bg-success-soft border border-success-subtle text-fg-success-strong text-xs font-medium px-1.5 py-0.5 rounded">
            <?= htmlspecialchars($_SESSION['badge']['message']) ?>
          </span>
        <?php else: ?>
          <span class="bg-danger-soft border border-danger-subtle text-fg-danger-strong text-xs font-medium px-1.5 py-0.5 rounded">
            <?= htmlspecialchars($_SESSION['badge']['message']) ?>
          </span>
        <?php endif; ?>
      </div>
      <?php unset($_SESSION['badge']); ?>
    <?php endif; ?>
  </div>

  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-xl">
    <div class="rounded-xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
      <form action="../controllers/user_connect.php" method="POST" class="space-y-6">
        <div>
          <label 
            for="email" 
            class="block mb-2 text-sm font-medium text-gray-900">
            Email address
          </label>
          <div class="mt-2">
            <input id="email" type="email" name="email" required autocomplete="email" placeholder="name@example.com" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 block w-full px-3 py-2.5 shadow-sm placeholder:text-gray-400 transition-colors" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between mb-2">
            <label 
              for="password" 
              class="block text-sm font-medium text-gray-900">
              Password
            </label>
          </div>
          <div class="mt-2">
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 block w-full px-3 py-2.5 shadow-sm placeholder:text-gray-400 transition-colors" />
          </div>
        </div>

        <div class="flex items-center justify-between pt-2">
          <div class="flex items-center gap-3">
             <button type="submit" name="login" class="text-white bg-gray-900 border border-transparent hover:bg-black focus:ring-4 focus:ring-gray-900/30 shadow-sm font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none transition-colors">Sign in</button>
          </div>
          <a href="#" class="text-sm font-semibold text-gray-900 hover:underline">Forgot password?</a>
        </div>
      </form>
    </div>

    <p class="mt-8 text-center text-sm/6 text-gray-500">
      Need an account?
      <a href="signUp.php" class="font-semibold text-gray-900 hover:underline">Create one</a>
    </p>
  </div>
</div>

</body>
</html>