<?php
require 'db.php';
if(isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $u = $stmt->fetch();
    if($u && password_verify($password, $u['password_hash'])) {
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['user_name'] = $u['name'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<header><h2>Login</h2><a href="index.php">Home</a></header>
<?php if(!empty($_GET['registered'])) echo "<div class='notice'>Registered successfully. Please login.</div>"; ?>
<?php if(!empty($error)) echo "<div class='notice'>$error</div>"; ?>
<form method="post">
 <div class="form-row"><label>Email</label><input type="email" name="email"></div>
 <div class="form-row"><label>Password</label><input type="password" name="password"></div>
 <button class="btn-primary" name="login">Login</button>
</form>
<p class="small">New user? <a href="register.php">Register</a></p>
</div></body></html>
