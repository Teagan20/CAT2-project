<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle ?? 'CAT2 Server Admin') ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="bar">
  <a class="brand" href="index.php">CAT2 Server</a>
  <nav>
    <?php if (!empty($_SESSION['user'])): ?>
      <a href="dashboard.php">Dashboard</a>
      <a href="feedback.php">Feedback</a>
      <a href="logout.php">Log out</a>
    <?php else: ?>
      <a href="login.php">Log in</a>
      <a href="signup.php">Sign up</a>
    <?php endif; ?>
  </nav>
</header>
<main>
