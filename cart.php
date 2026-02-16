<?php
session_start();
$conn = new mysqli("localhost", "root", "", "login");
if ($conn->connect_error)
    die("Database connection failed");

// Fetch cart items
$cart_items = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="ku">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f3f6;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .1);
            margin: 10px;
            text-align: center;
            width: 250px;
            display: inline-block;
            background: #fff;
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }

        .price {
            color: #16a34a;
            font-weight: bold;
        }

        .checkout-btn {
            background: #16a34a;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
        }

        .checkout-btn:hover {
            background: #12812b;
        }

        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <h1>🛒 My Cart</h1>

        <?php
        if (!empty($cart_items)) {
            foreach ($cart_items as $id) {
                $res = $conn->query("SELECT * FROM products WHERE id='$id'");
                if ($res->num_rows > 0) {
                    $row = $res->fetch_assoc();
                    $total += $row['price'];
                    echo "
            <div class='card'>
                <img src='uploads/" . $row['image'] . "' alt='" . $row['name'] . "'>
                <h5>" . $row['brand'] . " " . $row['name'] . "</h5>
                <p>Storage: " . $row['storage'] . "</p>
                <p>Color: " . $row['color'] . "</p>
                <p class='price'>$" . $row['price'] . "</p>
            </div>";
                }
            }
            echo "<h3>Total: $" . $total . "</h3>";
            echo "<button class='checkout-btn' onclick=\"alert('💳 Payment successful!')\">💳 Checkout</button>";
        } else {
            echo "<p>Your cart is empty.</p>";
        }
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>