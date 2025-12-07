<?php
require 'db.php';
$st = $pdo->query("SELECT voting_open FROM settings WHERE id=1")->fetch();
$voting_open = $st ? (bool)$st['voting_open'] : false;

// get counts
$stmt = $pdo->query("
  SELECT c.id, c.name, c.party, COUNT(v.id) AS votes
  FROM candidates c
  LEFT JOIN votes v ON v.candidate_id = c.id
  GROUP BY c.id ORDER BY votes DESC
");
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Results</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<header><h2>Election Results</h2><a href="index.php">Home</a></header>

<?php if($voting_open): ?>
  <div class="notice">Voting is still open. Results will be shown after voting is closed.</div>
<?php endif; ?>

<section>
  <?php foreach($rows as $r): ?>
    <div class="candidate">
      <div>
        <strong><?=htmlspecialchars($r['name'])?></strong>
        <div class="small"><?=htmlspecialchars($r['party'])?></div>
      </div>
      <div><strong><?= (int)$r['votes'] ?></strong> votes</div>
    </div>
  <?php endforeach; ?>
</section>

<?php if(isset($_GET['voted'])) echo "<div class='notice'>Vote recorded. Thank you!</div>"; ?>

</div></body></html>
