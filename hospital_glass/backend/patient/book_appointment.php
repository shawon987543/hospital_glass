<?php
require_once __DIR__ . '/../init.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!=='patient'){
    header('Location: /backend/auth/login.php'); exit;
}
$user_id = $_SESSION['user']['id'];
// get patient_id
$stmt = $pdo->prepare("SELECT * FROM patients WHERE user_id = ?");
$stmt->execute([$user_id]);
$patient = $stmt->fetch();
if(!$patient){ exit('Patient record missing'); }
$patient_id = $patient['patient_id'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $doctor_id = (int)$_POST['doctor_id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];
    $stmt = $pdo->prepare("INSERT INTO appointments (patient_id,doctor_id,appointment_date,appointment_time) VALUES (?,?,?,?)");
    $stmt->execute([$patient_id,$doctor_id,$date,$time]);
    header('Location: book_appointment.php?success=1'); exit;
}

$docs = $pdo->query("SELECT d.doctor_id, u.name, d.specialization FROM doctors d JOIN users u ON d.user_id=u.id")->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Book Appointment</title><link rel="stylesheet" href="/frontend/assets/css/style.css"></head>
<body>
  <div class="container">
    <a href="/backend/auth/logout.php" class="btn small">Logout</a>
    <h2>Book Appointment</h2>
    <?php if(isset($_GET['success'])) echo '<p class="success">Appointment booked successfully.</p>'; ?>
    <div class="glass-card">
      <form method="post">
        <label>Doctor</label>
        <select name="doctor_id" required>
          <?php foreach($docs as $d): ?>
            <option value="<?=$d['doctor_id']?>"><?=htmlspecialchars($d['name'].' - '.$d['specialization'])?></option>
          <?php endforeach; ?>
        </select>
        <label>Date</label>
        <input type="date" name="appointment_date" required>
        <label>Time</label>
        <input name="appointment_time" placeholder="e.g. 10:00 AM" required>
        <button class="btn" type="submit">Book</button>
      </form>
    </div>
  </div>
</body></html>
