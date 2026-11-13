<?php
// Database connection used by every page.
$DB_HOST = "localhost";
$DB_USER = "catuser";
$DB_PASS = "StrongPass123";
$DB_NAME = "CAT2";

mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed: " . htmlspecialchars($conn->connect_error));
}
$conn->set_charset("utf8mb4");

function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
