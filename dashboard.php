<?php
session_start();
if (empty($_SESSION['user'])) { header("Location: login.php"); exit; }
require 'config.php';
$pageTitle = "Dashboard";
include 'header.php';
?>
<div class="card">
  <h1>Welcome, <?= e($_SESSION['user']) ?></h1>
  <p class="sub">Logged in as <?= e($_SESSION['fullname']) ?>. Login successful.</p>
  <p><a href="feedback.php">Go to the feedback form</a></p>
</div>
<?php include 'footer.php'; ?>
