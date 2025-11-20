<?php
require_once __DIR__ . '/../init.php';
require_role('admin');

$patients = $pdo->query("SELECT p.*, u.name, u.email FROM patients p JOIN users u ON p.user_id=u.id ORDER BY p.created_at DESC")->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Patients</title><link rel="stylesheet" href="/frontend/assets/css/style.css"></head>
<body>
  <div class="container">
    <a href="dashboard.php" class="btn small">Back</a><h2>Patients</h2>
    <table>
      <thead><tr><th>Name</th><th>Email</th><th>Age</th><th>Phone</th></tr></thead>
      <tbody>
        <?php foreach($patients as $p): ?>
          <tr>
            <td><?=htmlspecialchars($p['name'])?></td>
            <td><?=htmlspecialchars($p['email'])?></td>
            <td><?=htmlspecialchars($p['age'])?></td>
            <td><?=htmlspecialchars($p['phone'])?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body></html>
