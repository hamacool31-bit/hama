<?php
$conn = new mysqli("localhost", "root", "", "login");
if ($conn->connect_error) {
    die("Connection failed");
}

$user_id = 6; // id ـی ئەو یوزەرەی دەتەوێت ئەپدێت بکرێت

// ئەپدێت کردن
if (isset($_POST['update'])) {

    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];

    // ئەگەر پاسۆرد نوێ داخڵ کرا
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $sql = "UPDATE users SET 
                FirstName='$first',
                LastName='$last',
                Email='$email',
                Password='$password'
                WHERE id=$user_id";
    } else {
        $sql = "UPDATE users SET 
                FirstName='$first',
                LastName='$last',
                Email='$email'
                WHERE id=$user_id";
    }

    $conn->query($sql);
    header("Location: profile.php");
    exit();
}

// هێنانی زانیاری یوزەر
$result = $conn->query("SELECT * FROM users WHERE id=$user_id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Edit Profile</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }

        .box {
            background: #fff;
            width: 400px;
            margin: 60px auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <div class="box">
        <h2 style="text-align:center;">Edit Profile</h2>

        <form method="POST">

            <label>First Name</label>
            <input type="text" name="first" value="<?php echo $user['FirstName']; ?>" required>

            <label>Last Name</label>
            <input type="text" name="last" value="<?php echo $user['LastName']; ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?php echo $user['Email']; ?>" required>

            <label>New Password (optional)</label>
            <input type="password" name="password" placeholder="Leave empty if you don't want to change">

            <button type="submit" name="update">Update</button>

        </form>
    </div>

</body>

</html>