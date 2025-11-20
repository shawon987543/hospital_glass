<?php
require_once __DIR__ . '/../init.php';
require_role('admin');

$user = $_SESSION['user'];
// fetch counts
$totDoctors = $pdo->query("SELECT COUNT(*) FROM doctors")->fetchColumn();
$totPatients = $pdo->query("SELECT COUNT(*) FROM patients")->fetchColumn();
$totAppts = $pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/frontend/assets/css/style.css">
</head>
<body>
  <div class="container">
    <nav class="top-nav">
      <h3>Admin Panel</h3>
      <div>Welcome, <?=htmlspecialchars($user['name'])?> | <a href="/backend/auth/logout.php">Logout</a></div>
    </nav>

    <div class="dashboard-grid">
      <div class="card glass-card"><h4>Doctors</h4><p><?=$totDoctors?></p><a class="link" href="manage_doctors.php">Manage</a></div>
      <div class="card glass-card"><h4>Patients</h4><p><?=$totPatients?></p><a class="link" href="manage_patients.php">Manage</a></div>
      <div class="card glass-card"><h4>Appointments</h4><p><?=$totAppts?></p><a class="link" href="manage_appointments.php">Manage</a></div>
    </div>
  </div>
</body>
</html>
