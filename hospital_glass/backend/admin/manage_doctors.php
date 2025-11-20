<?php
require_once __DIR__ . '/../init.php';
require_role('admin');

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_doctor'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $spec = $_POST['specialization'];
    $phone = $_POST['phone'];
    $visiting = $_POST['visiting_hour'];

    // create user
    $pdo->beginTransaction();
    $pwdHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
    $stmt->execute([$name,$email,$pwdHash,'doctor']);
    $uid = $pdo->lastInsertId();
    $stmt2 = $pdo->prepare("INSERT INTO doctors (user_id,specialization,phone,visiting_hour) VALUES (?,?,?,?)");
    $stmt2->execute([$uid,$spec,$phone,$visiting]);
    $pdo->commit();

    header('Location: manage_doctors.php');
    exit;
}

$doctors = $pdo->query("SELECT d.*, u.email, u.name FROM doctors d JOIN users u ON d.user_id=u.id ORDER BY d.created_at DESC")->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><title>Manage Doctors</title>
  <link rel="stylesheet" href="/frontend/assets/css/style.css">
</head>
<body>
  <div class="container">
    <a href="dashboard.php" class="btn small">Back</a>
    <h2>Doctors</h2>

    <div class="glass-card">
      <h3>Add Doctor</h3>
      <form method="post">
        <input name="name" placeholder="Name" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Password" required>
        <input name="specialization" placeholder="Specialization">
        <input name="phone" placeholder="Phone">
        <input name="visiting_hour" placeholder="Visiting Hour">
        <button name="add_doctor" class="btn">Add Doctor</button>
      </form>
    </div>

    <table>
      <thead><tr><th>Name</th><th>Email</th><th>Spec</th><th>Phone</th></tr></thead>
      <tbody>
        <?php foreach($doctors as $d): ?>
          <tr>
            <td><?=htmlspecialchars($d['name'])?></td>
            <td><?=htmlspecialchars($d['email'])?></td>
            <td><?=htmlspecialchars($d['specialization'])?></td>
            <td><?=htmlspecialchars($d['phone'])?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</body>
</html>
