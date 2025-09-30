<?php
session_start();

$message = '';
$message_class = '';

$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

/* ---- FORM SUBMISSION ---- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');
  $confirm  = trim($_POST['confirm'] ?? '');

  if ($username === '' || $password === '' || $confirm === '') {
    $message = "All fields are required!";
    $message_class = "error";
  } elseif ($password !== $confirm) {
    $message = "Passwords do not match!";
    $message_class = "error";
  } elseif (isset($users[$username])) {
    $message = "Username already exists!";
    $message_class = "error";
  } else {
    // Save user with password hash
    $users[$username] = password_hash($password, PASSWORD_DEFAULT);
    file_put_contents($usersFile, json_encode($users));
    $_SESSION['flash'] = ['type'=>'success','text'=>'Registration successful. You can now log in.'];
    header('Location: login.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <style>
    body {
      margin:0; 
      height:100vh; 
      display:flex; 
      justify-content:center; 
      align-items:center;
      background:#121212; 
      font-family:Arial, sans-serif; 
      color:#e5e5e5;
    }

    form {
      border:1px solid #2d2d2d; 
      background:#1e1e1e; 
      padding:30px; 
      padding-right: 50px;
      border-radius:8px;
      width:100%; 
      max-width:360px; 
      box-shadow:0 4px 12px rgba(0,0,0,0.6);
    }

    h2 { 
        text-align:center; 
        color:#fff; 
        margin-bottom:16px; 
    }

    label { 
        display:block; 
        margin:10px 0 6px; 
        text-align:left; 
    }

    input {
      width:100%; 
      padding:10px; 
      margin-bottom:12px; 
      border-radius:6px; 
      border:1px solid #333;
      background:#2b2b2b; 
      color:#e5e5e5;
    }
    
    input:focus { 
        border-color:#4f46e5; 
        outline:none;
    }

    button {
      width:100%; 
      padding:10px; 
      background:#4f46e5; 
      border:none; 
      border-radius:6px; 
      color:#fff; 
      cursor:pointer;
    }

    button:hover { background:#4338ca; }
    .message { 
        margin-bottom:12px; 
        padding:10px; 
        border-radius:6px; 
        text-align:center; 
    }

    .error   { 
        background:#7f1d1d; 
        color:#fecaca; 
        border:1px solid #991b1b; 
    }

    .success { 
        background:#14532d; 
        color:#bbf7d0; 
        border:1px solid #15803d; 
    }

    .note { 
        font-size:12px; 
        color:#9ca3af; 
        margin-top:8px; 
        text-align:center; 
    }

    .note a { 
        color:#818cf8; 
        text-decoration:none; 
    }

    .note a:hover { text-decoration:underline; }
  </style>
</head>
<body>
  <form method="post" action="">
    <h2>Register</h2>

    <?php if ($message): ?>
      <div class="message <?= $message_class ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <label for="username">Username</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <label for="confirm">Confirm Password</label>
    <input type="password" name="confirm" id="confirm" required>

    <button type="submit">Register</button>
    <div class="note">Already have an account? <a href="login.php">Login here</a></div>
  </form>
</body>
</html>
