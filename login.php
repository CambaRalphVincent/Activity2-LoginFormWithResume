<?php
session_start();

$message = '';
$message_class = '';
$login_success = false;

$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

/* ---- FLASH MESSAGE (from logout or registration) ---- */
if (!empty($_SESSION['flash'])) {
  $message = $_SESSION['flash']['text'] ?? '';
  $message_class = $_SESSION['flash']['type'] ?? 'success';
  unset($_SESSION['flash']);
}

/* ---- ALREADY LOGGED IN ---- */
if (!empty($_SESSION['auth'])) {
  header('Location: resume.php');
  exit;
}

/* ---- FORM SUBMISSION ---- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($username === '' || $password === '') {
    $message = 'All fields are required!';
    $message_class = 'error';
  } elseif (isset($users[$username]) && password_verify($password, $users[$username])) {
    $_SESSION['auth'] = true;
    $_SESSION['user'] = $username;
    $message = 'Login Successful';
    $message_class = 'success';
    $login_success = true;
  } else {
    $message = 'Invalid Username or Password';
    $message_class = 'error';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      margin: 0; 
      height: 100vh; 
      display: flex; 
      justify-content: center; 
      align-items: center;
      background: #121212; 
      font-family: Arial, sans-serif; 
      color: #e5e5e5;
    }

    form {
      border: 1px solid #2d2d2d; 
      background: #1e1e1e; 
      padding: 30px;
      padding-right: 50px; 
      border-radius: 8px;
      width: 100%; 
      max-width: 360px; 
      box-shadow: 0 4px 12px rgba(0,0,0,0.6);
    }
    h2 { 
      text-align: center; 
      color: #fff; 
      margin-bottom: 16px; }

    label { 
      display: block; 
      margin: 10px 0 6px; 
      text-align: left; }

    input {
      width: 100%; 
      padding: 10px; 
      margin-bottom: 12px; 
      border-radius: 6px; 
      border: 1px solid #333;
      background: #2b2b2b; color: #e5e5e5;
    }

    input:focus { 
      border-color: #4f46e5; 
      outline: none; 
    }

    button {
      width: 100%; 
      padding: 10px; 
      background: #4f46e5; 
      border: none; 
      border-radius: 6px; 
      color: #fff; cursor: pointer;
    }

    button:hover { background: #4338ca; }

    .message { 
      margin-bottom: 12px; 
      padding: 10px; 
      border-radius: 6px; 
      text-align: center; }

    .error   { 
      background: #7f1d1d; 
      color: #fecaca; 
      border: 1px solid #991b1b; 
    }

    .success { 
      background: #14532d; 
      color: #bbf7d0; 
      border: 1px solid #15803d; 
    }

    .note { 
      font-size: 12px; 
      color: #9ca3af; 
      margin-top: 8px; 
      text-align: center; 
    }

    .note a { 
      color: #818cf8; 
      text-decoration: none; 
    }

    .note a:hover { text-decoration: underline; }


  </style>
</head>
<body>
  <form method="post" action="">
    <h2>Login</h2>

    <?php if ($message): ?>
      <div class="message <?= $message_class ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($login_success): ?>
      <button type="button" onclick="window.location.href='resume.php'">Continue to Resume</button>
    <?php else: ?>
      <label for="username">Username</label>
      <input type="text" name="username" id="username" value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" autofocus required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>

      <button type="submit">Login</button>
      <div class="note">Don’t have an account? <a href="register.php">Register here</a></div>
    <?php endif; ?>
  </form>
</body>
</html>
