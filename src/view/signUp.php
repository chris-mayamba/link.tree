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
  <title><?= $title ="Inscription" ?></title>
  <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
  <link rel="stylesheet" href="../public/style.css">
</head>
<body class="h-full">

<div class="flex min-h-full flex-col justify-center px-4 py-12 sm:px-6 lg:px-8 bg-gray-50">
  <div class="sm:mx-auto sm:w-full sm:max-w-xl">
    <div class="mb-6 flex flex-col items-start">
      <h2 class="text-xl font-bold tracking-tight text-gray-900">Create Account</h2>
      <p class="text-sm text-gray-500">Join us to start creating your links.</p>
    </div>

    <?php if (isset($_SESSION['badge'])): ?>
      <div class="mt-4 text-center">
        <?php if ($_SESSION['badge']['type'] === 'success'): ?>
          <span class="bg-green-500/20 border border-green-500/50 text-green-400 text-xs font-medium px-2.5 py-1 rounded">
            <?= htmlspecialchars($_SESSION['badge']['message']) ?>
          </span>
        <?php else: ?>
          <span class="bg-red-500/20 border border-red-500/50 text-red-400 text-xs font-medium px-2.5 py-1 rounded">
            <?= htmlspecialchars($_SESSION['badge']['message']) ?>
          </span>
        <?php endif; ?>
      </div>
      <?php unset($_SESSION['badge']); ?>
    <?php endif; ?>
  </div>

  <div class="sm:mx-auto sm:w-full sm:max-w-xl">
 
    <div class="rounded-xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">

      <form action="../controllers/user_register.php" method="POST" class="space-y-6">
        <div>
          <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
          <div class="mt-2">
            <input id="username" type="text" name="username" required placeholder="Your username" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 block w-full px-3 py-2.5 shadow-sm placeholder:text-gray-400 transition-colors" />
          </div>
        </div>

        <div>
          <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email address</label>
          <div class="mt-2">
            <input id="email" type="email" name="email" required placeholder="name@example.com" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 block w-full px-3 py-2.5 shadow-sm placeholder:text-gray-400 transition-colors" />
          </div>
        </div>

        <div>
          <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
          <div class="mt-2">
            <input id="password" type="password" name="password" required placeholder="••••••••" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 block w-full px-3 py-2.5 shadow-sm placeholder:text-gray-400 transition-colors" />
          </div>
        </div>

        <p class="text-sm text-gray-500 pt-2">By submitting this form, you agree to our terms and conditions.</p>

        <div class="flex items-center gap-3 pt-4">
          <button type="reset" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 shadow-sm font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none transition-colors">Reset</button>
          <button type="submit" name="register" class="text-white bg-gray-900 border border-transparent hover:bg-black focus:ring-4 focus:ring-gray-900/30 shadow-sm font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none transition-colors">Submit</button>
        </div>
      </form>
    </div>

    <p class="mt-8 text-center text-sm/6 text-gray-500">
      Already have an account?
      <a href="login.php" class="font-semibold text-gray-900 hover:underline">Log in</a>
    </p>
  </div>
</div>

</body>
</html>
