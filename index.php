<?php
require 'db.php';
$stmt = $pdo->query("SELECT * FROM jobs ORDER BY posted_at DESC");
$jobs = $stmt->fetchAll();
$logged_in = isset($_SESSION['user_id']);
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Home — EVS</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<header>
  <h1>Electronic Voting System</h1>
  <div>
    <?php if($logged_in): ?>
      Welcome, <?=htmlspecialchars($_SESSION['user_name'])?> |
      <a href="candidates.php">Vote</a> |
      <a href="results.php">Results</a> |
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a> |
      <a href="register.php">Register</a> |
      <a href="results.php">Results</a>
    <?php endif; ?>
  </div>
</header>

<section>
  <h3>Available Jobs (dynamically loaded)</h3>
  <?php foreach($jobs as $j): ?>
    <div class="job">
      <strong><?=htmlspecialchars($j['title'])?></strong>
      <div class="small"><?=htmlspecialchars($j['company'])?> — <?=htmlspecialchars($j['location'])?></div>
      <p><?=nl2br(htmlspecialchars($j['description']))?></p>
      <div class="small">Posted: <?=htmlspecialchars($j['posted_at'])?></div>
    </div>
  <?php endforeach; ?>
  <?php if(empty($jobs)) echo "<p>No jobs right now.</p>"; ?>
</section>

<footer class="small" style="margin-top:20px">Admin: <a href="admin.php">Open Admin</a></footer>

</div></body></html>
