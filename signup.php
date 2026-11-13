<?php
require 'config.php';
$pageTitle = "Sign up";
$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if ($username === '' || $fullname === '' || $email === '' || $password === '') {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Enter a valid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $error = "That username is taken. Choose another.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, fullname, email, password) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $username, $fullname, $email, $hash);
            if ($stmt->execute()) {
                $success = "Account created for " . e($username) . ". You can now log in.";
            } else {
                $error = "Could not create the account. Try again.";
            }
        }
    }
}
include 'header.php';
?>
<div class="card">
  <h1>Create an account</h1>
  <p class="sub">Register to access the dashboard and feedback form.</p>
  <?php if ($error): ?><div class="msg err"><?= e($error) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="msg ok"><?= $success ?></div><?php endif; ?>
  <form method="POST" autocomplete="off">
    <label for="username">Username</label>
    <input id="username" name="username" required>
    <label for="fullname">Full name</label>
    <input id="fullname" name="fullname" required>
    <label for="email">Email</label>
    <input id="email" name="email" type="email" required>
    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>
    <label for="confirm">Confirm password</label>
    <input id="confirm" name="confirm" type="password" required>
    <button type="submit">Create account</button>
  </form>
  <p class="alt">Already registered? <a href="login.php">Log in</a></p>
</div>
<?php include 'footer.php'; ?>
