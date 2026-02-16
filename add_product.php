<?php
$conn = new mysqli("localhost", "root", "", "login");
if ($conn->connect_error)
    die("Connection failed");

if (isset($_POST['submit'])) {
    $img = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $img);

    $conn->query("INSERT INTO products (brand,name,storage,color,price,image)
                  VALUES ('{$_POST['brand']}','{$_POST['name']}','{$_POST['storage']}','{$_POST['color']}','{$_POST['price']}','$img')");

    // Redirect to index.php after adding
    header("Location: mobile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: 20px auto;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center">Add Mobile</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="brand" placeholder="Brand" required>
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="storage" placeholder="Storage" required>
        <input type="text" name="color" placeholder="Color" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="file" name="image" required>
        <button type="submit" name="submit"><i class="fas fa-plus"></i> Add</button>
    </form>
</body>

</html>