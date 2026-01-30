<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenu</title>
</head>
<body>
    <?php if (isset($_SESSION['flash'])): ?>
      <div style="margin: 20px;">
        <?php if ($_SESSION['flash']['type'] === 'success'): ?>
          <span class="bg-success-soft border border-success-subtle text-fg-success-strong text-xs font-medium px-1.5 py-0.5 rounded">
            <?= htmlspecialchars($_SESSION['flash']['message']) ?>
          </span>
        <?php endif; ?>
      </div>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    Bienvenu
</body>
</html>