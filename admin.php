<?php
require 'db.php';
// NOTE: for demo keep a simple admin pass. In production, secure this properly.
define('ADMIN_PASS','admin123'); // change this BEFORE using

$info = '';
if(isset($_POST['admin_pass'])) {
    if($_POST['admin_pass'] !== ADMIN_PASS) {
        $info = "Invalid admin password.";
    } else {
        // toggle voting if requested
        if(isset($_POST['action']) && $_POST['action'] === 'toggle') {
            $current = $pdo->query("SELECT voting_open FROM settings WHERE id=1")->fetch();
            $new = $current ? (1 - (int)$current['voting_open']) : 0;
            $stmt = $pdo->prepare("UPDATE settings SET voting_open = ? WHERE id=1");
            $stmt->execute([$new]);
            $info = $new ? "Voting opened." : "Voting closed.";
        }
    }
}

$st = $pdo->query("SELECT voting_open FROM settings WHERE id=1")->fetch();
$voting_open = $st ? (bool)$st['voting_open'] : false;
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Admin</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<header><h2>Admin Panel</h2><a href="index.php">Home</a></header>
<?php if($info) echo "<div class='notice'>$info</div>"; ?>
<p class="small">Current status: <strong><?= $voting_open ? 'OPEN' : 'CLOSED' ?></strong></p>

<form method="post">
  <div class="form-row"><label>Admin password</label><input type="password" name="admin_pass" required></div>
  <input type="hidden" name="action" value="toggle">
  <button class="btn-primary" type="submit">Toggle Voting</button>
</form>

<p class="small" style="margin-top:12px">Tip: change ADMIN_PASS in admin.php for your site.</p>
</div></body></html>
