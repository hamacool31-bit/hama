<?php
session_start();

// Login demo
if (isset($_POST['login'])) {
    if ($_POST['email'] === 'test@gmail.com' && $_POST['password'] === '1234') {
        $_SESSION['name'] = 'Mohamad';
        header('Location: index.php'); // بڕۆ بۆ home page
        exit;
    } else {
        $error = "Invalid login";
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>

    <?php if (isset($error))
        echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>

</body>

</html>