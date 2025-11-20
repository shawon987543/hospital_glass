<?php
require_once __DIR__ . '/../config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $age = (int)$_POST['age'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // create user & patient
    $pdo->beginTransaction();
    $pwdHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
    $stmt->execute([$name,$email,$pwdHash,'patient']);
    $uid = $pdo->lastInsertId();
    $stmt2 = $pdo->prepare("INSERT INTO patients (user_id,age,gender,phone,address) VALUES (?,?,?,?,?)");
    $stmt2->execute([$uid,$age,$gender,$phone,$address]);
    $pdo->commit();

    header('Location: /backend/auth/login.php'); exit;
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Register Patient</title><link rel="stylesheet" href="/frontend/assets/css/style.css"></head>
<body>
<div class="glass-card auth-card">
  <h2>রেজিস্টার (Patient)</h2>
  <form method="post">
    <input name="name" placeholder="নাম" required>
    <input name="email" type="email" placeholder="ইমেইল" required>
    <input name="password" type="password" placeholder="পাসওয়ার্ড" required>
    <input name="age" type="number" placeholder="বয়স">
    <select name="gender"><option>Male</option><option>Female</option><option>Other</option></select>
    <input name="phone" placeholder="ফোন">
    <input name="address" placeholder="ঠিকানা">
    <button class="btn" type="submit">রেজিস্টার</button>
  </form>
  <p><a href="/frontend/index.html">Back</a></p>
</div>
</body></html>
