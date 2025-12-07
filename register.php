<?php
require 'db.php';
if(isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if(!$name || !$email || !$password){
        $error = "All fields required.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name,email,password_hash) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$name,$email,$hash]);
            header("Location: login.php?registered=1");
            exit;
        } catch (PDOException $e) {
            $error = "Email already registered.";
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Register</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<header><h2>Register</h2><a href="index.php">Home</a></header>
<?php if(!empty($error)) echo "<div class='notice'>$error</div>"; ?>
<form method="post">
 <div class="form-row"><label>Name</label><input type="text" name="name"></div>
 <div class="form-row"><label>Email</label><input type="email" name="email"></div>
 <div class="form-row"><label>Password</label><input type="password" name="password"></div>
 <button class="btn-primary" name="register">Register</button>
</form>
<p class="small">Already have account? <a href="login.php">Login</a></p>
</div></body></html>
