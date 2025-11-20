<?php
require_once __DIR__ . '/../init.php';
require_role('admin');

if(isset($_GET['action'], $_GET['id'])){
    $id = (int)$_GET['id'];
    if($_GET['action'] === 'approve') {
        $pdo->prepare("UPDATE appointments SET status='Approved' WHERE appointment_id=?")->execute([$id]);
    } elseif($_GET['action'] === 'cancel') {
        $pdo->prepare("UPDATE appointments SET status='Cancelled' WHERE appointment_id=?")->execute([$id]);
    }
    header('Location: manage_appointments.php'); exit;
}

$appts = $pdo->query("SELECT a.*, u.name AS patient_name, ud.name AS doctor_name FROM appointments a
JOIN patients p ON a.patient_id=p.patient_id
JOIN users u ON p.user_id=u.id
JOIN doctors d ON a.doctor_id=d.doctor_id
JOIN users ud ON d.user_id=ud.id
ORDER BY a.created_at DESC")->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Appointments</title><link rel="stylesheet" href="/frontend/assets/css/style.css"></head>
<body>
  <div class="container">
    <a href="dashboard.php" class="btn small">Back</a><h2>Appointments</h2>
    <table>
      <thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        <?php foreach($appts as $a): ?>
          <tr>
            <td><?=htmlspecialchars($a['patient_name'])?></td>
            <td><?=htmlspecialchars($a['doctor_name'])?></td>
            <td><?=htmlspecialchars($a['appointment_date'])?></td>
            <td><?=htmlspecialchars($a['appointment_time'])?></td>
            <td><?=htmlspecialchars($a['status'])?></td>
            <td>
              <a href="?action=approve&id=<?=$a['appointment_id']?>">Approve</a> |
              <a href="?action=cancel&id=<?=$a['appointment_id']?>">Cancel</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body></html>
