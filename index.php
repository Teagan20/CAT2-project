<?php
session_start();
header("Location: " . (!empty($_SESSION['user']) ? "dashboard.php" : "login.php"));
exit;
