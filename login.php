<?php
session_start();
require 'config.php';
$pageTitle = "Log in";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        session_regenerate_id(true);
        $_SESSION['user']     = $username;
        $_SESSION['fullname'] = $row['fullname'];
        header("Location: dashboard.php");
        exit;
    }
    $error = "Invalid username or password.";
}
include 'header.php';
?>
<div class="card">
  <h1>Log in to CAT2</h1>
  <p class="sub">Use the account you registered.</p>
  <?php if ($error): ?><div class="msg err"><?= e($error) ?></div><?php endif; ?>
  <form method="POST">
    <label for="username">Username</label>
    <input id="username" name="username" required>
    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>
    <button type="submit">Log in</button>
  </form>
  <p class="alt">No account yet? <a href="signup.php">Sign up</a></p>
</div>
<?php include 'footer.php'; ?>
