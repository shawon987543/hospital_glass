<?php
require_once __DIR__ . '/../config.php';
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])){
        // Successful login
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        // redirect based on role
        if($user['role'] === 'admin') header('Location: /backend/admin/dashboard.php');
        elseif($user['role'] === 'doctor') header('Location: /backend/doctor/dashboard.php');
        else header('Location: /backend/patient/dashboard.php');
        exit;
    } else {
        $error = "ইমেইল বা পাসওয়ার্ড ভুল।";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login - Hospital</title>
  <link rel="stylesheet" href="/frontend/assets/css/style.css">
</head>
<body>
  <div class="glass-card auth-card">
    <h2>লগইন</h2>
    <?php if(!empty($error)) echo "<p class='error'>{$error}</p>"; ?>
    <form method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" class="btn">লগইন</button>
    </form>
    <p><a href="/frontend/index.html">Back to Home</a></p>
  </div>
</body>
</html>
