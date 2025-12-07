<?php
require 'db.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if(!isset($_POST['candidate_id'])) {
    header("Location: candidates.php");
    exit;
}
$candidate_id = (int)$_POST['candidate_id'];
$user_id = $_SESSION['user_id'];

// begin transaction
$pdo->beginTransaction();
try {
    // check voting open
    $st = $pdo->query("SELECT voting_open FROM settings WHERE id=1 FOR UPDATE")->fetch();
    if(!$st || !$st['voting_open']) {
        throw new Exception("Voting is closed.");
    }

    // check if user already voted (lock user row)
    $usr = $pdo->prepare("SELECT has_voted FROM users WHERE id=? FOR UPDATE");
    $usr->execute([$user_id]);
    $r = $usr->fetch();
    if(!$r) throw new Exception("User not found.");
    if($r['has_voted']) throw new Exception("You have already voted.");

    // insert vote
    $iv = $pdo->prepare("INSERT INTO votes (user_id, candidate_id) VALUES (?, ?)");
    $iv->execute([$user_id, $candidate_id]);

    // mark user as voted
    $upd = $pdo->prepare("UPDATE users SET has_voted = 1 WHERE id = ?");
    $upd->execute([$user_id]);

    $pdo->commit();
    header("Location: results.php?voted=1");
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    $err = $e->getMessage();
    header("Location: candidates.php?error=" . urlencode($err));
    exit;
}
