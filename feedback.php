<?php
session_start();
if (empty($_SESSION['user'])) { header("Location: login.php"); exit; }
require 'config.php';
$pageTitle = "Feedback";
$notice = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name !== '' && $message !== '') {
        $stmt = $conn->prepare("INSERT INTO feedback (name, message) VALUES (?,?)");
        $stmt->bind_param("ss", $name, $message);
        $stmt->execute();
        $notice = "Feedback saved to the database.";
    }
}
$rows = $conn->query("SELECT name, message, created_at FROM feedback ORDER BY id DESC");
include 'header.php';
?>
<div class="card">
  <h1>Feedback</h1>
  <p class="sub">Submitted entries are stored in the CAT2 database and listed below.</p>
  <?php if ($notice): ?><div class="msg ok"><?= e($notice) ?></div><?php endif; ?>
  <form method="POST">
    <label for="name">Name</label>
    <input id="name" name="name" value="<?= e($_SESSION['fullname']) ?>" required>
    <label for="message">Message</label>
    <textarea id="message" name="message" required></textarea>
    <button type="submit">Send feedback</button>
  </form>
</div>
<div class="card" style="margin-top:20px">
  <h1>Retrieved from the table</h1>
  <?php if ($rows && $rows->num_rows): foreach ($rows as $r): ?>
    <div class="entry"><strong><?= e($r['name']) ?></strong> <small><?= e($r['created_at']) ?></small><br><?= nl2br(e($r['message'])) ?></div>
  <?php endforeach; else: ?>
    <p class="sub">No feedback yet. Send the first message above.</p>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
