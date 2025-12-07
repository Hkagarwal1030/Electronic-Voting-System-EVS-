<?php
require 'db.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$userId = $_SESSION['user_id'];

// check voting status
$st = $pdo->query("SELECT voting_open FROM settings WHERE id=1")->fetch();
$voting_open = $st ? (bool)$st['voting_open'] : false;

// check if user already voted
$u = $pdo->prepare("SELECT has_voted FROM users WHERE id = ?");
$u->execute([$userId]);
$user = $u->fetch();
$has_voted = (bool)$user['has_voted'];

$cstmt = $pdo->query("SELECT * FROM candidates ORDER BY id");
$candidates = $cstmt->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Vote</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<header><h2>Cast Your Vote</h2><a href="index.php">Home</a></header>

<?php if(!$voting_open): ?>
  <div class="notice">Voting is currently closed. You can view results <a href="results.php">here</a>.</div>
<?php elseif($has_voted): ?>
  <div class="notice">You have already voted. Thank you! View results <a href="results.php">here</a>.</div>
<?php else: ?>
  <form method="post" action="vote_process.php">
    <?php foreach($candidates as $c): ?>
      <div class="candidate">
        <div>
          <strong><?=htmlspecialchars($c['name'])?></strong>
          <div class="small"><?=htmlspecialchars($c['party'])?> — <?=htmlspecialchars($c['description'])?></div>
        </div>
        <div>
          <input type="radio" name="candidate_id" value="<?= $c['id'] ?>" required>
        </div>
      </div>
    <?php endforeach; ?>
    <button class="btn-primary" type="submit" name="vote">Submit Vote</button>
  </form>
<?php endif; ?>

</div></body></html>
